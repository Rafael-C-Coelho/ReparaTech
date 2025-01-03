package pt.ipleiria.estg.dei.psi.projeto.reparatech.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;
import android.widget.Toast;

import androidx.annotation.Nullable;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkResponse;
import com.android.volley.NoConnectionError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.snackbar.Snackbar;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.Map;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Auth;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

// This class is responsible for making requests to the API

public class ApiHelper {

    public static int JSON_ARRAY_REQUEST = 1;
    public static int JSON_OBJECT_REQUEST = 2;
    public static int STRING_REQUEST = 3;

    public String base_url;

    private static RequestQueue requestQueue;

    public ApiHelper(Context context) {
        base_url = ReparaTechSingleton.getInstance(context).getSettings().getUrl();
        requestQueue = ReparaTechSingleton.getInstance(context).getVolleyQueue();
    }

    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager connectivityManager =
                (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();

        return networkInfo != null && networkInfo.isConnected();
    }

    public void request(Context context, int requestType, String endpoint, @Nullable JSONObject body, Response.Listener<JSONObject> responseListener, Response.ErrorListener errorListener) throws NoConnectionError {
        if (!isConnectionInternet(context)) {
            throw new NoConnectionError();
        }

        String url = base_url + endpoint;
        Log.d("ApiHelper", "Request URL: " + url);
        JsonObjectRequest request = new JsonObjectRequest(
                requestType,
                url,
                body,
                responseListener,
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        if (error.networkResponse != null) {
                            int statusCode = error.networkResponse.statusCode;
                            if (statusCode == 406) { // Triggered when the auth token is expired
                                try {
                                    request(
                                        context,
                                        requestType,
                                        "/api/auth/refresh-token",
                                        ReparaTechSingleton.getInstance(context).getRefreshTokenBody(),
                                        new Response.Listener<JSONObject>() {
                                            @Override
                                            public void onResponse(JSONObject response) {
                                                System.out.println("Token refreshed: " + response.toString());
                                                Auth auth = ReparaTechSingleton.getInstance(context).getAuth();
                                                auth.setToken(response.optString("access_token"));
                                                auth.setRefreshToken(response.optString("refresh_token"));
                                                ReparaTechSingleton.getInstance(context).updateAuth(auth);
                                                try {
                                                    request(context, requestType, endpoint, body, responseListener, errorListener);
                                                } catch (NoConnectionError e) {
                                                    Toast.makeText(context, "No internet connection", Toast.LENGTH_SHORT).show();
                                                }
                                            }
                                        },
                                        new Response.ErrorListener() {
                                            @Override
                                            public void onErrorResponse(VolleyError error) {
                                                errorListener.onErrorResponse(error);
                                            }
                                        }
                                    );
                                } catch (NoConnectionError e) {
                                    Toast.makeText(context, "No internet connection", Toast.LENGTH_SHORT).show();
                                }
                            }
                        } else {
                            errorListener.onErrorResponse(error);
                        }
                    }
                }
        ) {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                return ReparaTechSingleton.getInstance(context).getHeaders();
            }
        };

        requestQueue.add(request);
    }
}
