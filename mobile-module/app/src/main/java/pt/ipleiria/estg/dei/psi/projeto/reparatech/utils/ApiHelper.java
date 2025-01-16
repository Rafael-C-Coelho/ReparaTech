package pt.ipleiria.estg.dei.psi.projeto.reparatech.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.util.Log;
import android.widget.Toast;

import androidx.annotation.Nullable;

import com.android.volley.AuthFailureError;
import com.android.volley.NoConnectionError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;

import org.json.JSONObject;

import java.util.Map;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
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

        JSONObject requestBody406 = new JSONObject();
        try {
            requestBody406.put("refresh_token", ReparaTechSingleton.getInstance(context).getAuth().getRefreshToken());
        } catch (Exception e) {
            e.printStackTrace();
        }
        String url = ReparaTechSingleton.getInstance(context).getSettings().getUrl() + endpoint;
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
                                            Request.Method.POST,
                                            "/api/auth/refresh-token",
                                            requestBody406,
                                            new Response.Listener<JSONObject>() {
                                                @Override
                                                public void onResponse(JSONObject response) {
                                                    Log.d("ApiHelper", "Token refreshed: " + response.toString());
                                                    if (response.has("access_token")) {
                                                        Auth auth = ReparaTechSingleton.getInstance(context).getAuth();
                                                        auth.setToken(response.optString("access_token"));
                                                        auth.setRefreshToken(response.optString("refresh_token"));
                                                        ReparaTechSingleton.getInstance(context).updateAuth(auth);

                                                        // Retry the original request
                                                        try {
                                                            Log.d("ApiHelper", "Retrying original request: " + url);
                                                            request(context, requestType, endpoint, body, responseListener, errorListener);
                                                        } catch (NoConnectionError e) {
                                                            Toast.makeText(context, "No internet connection", Toast.LENGTH_SHORT).show();
                                                        }
                                                    } else {
                                                        Log.e("ApiHelper", context.getString(R.string.failed_to_refresh_token_login_again));
                                                        ReparaTechSingleton.getInstance(context).removeAuth();
                                                    }
                                                }
                                            },
                                            new Response.ErrorListener() {
                                                @Override
                                                public void onErrorResponse(VolleyError error) {
                                                    Log.e("ApiHelper", context.getString(R.string.failed_to_refresh_token_login_again));
                                                    errorListener.onErrorResponse(error);
                                                    ReparaTechSingleton.getInstance(context).removeAuth();
                                                }
                                            }
                                    );
                                } catch (NoConnectionError e) {
                                    Toast.makeText(context, context.getString(R.string.no_internet_connection), Toast.LENGTH_SHORT).show();
                                } catch (Exception e) {
                                    Log.e("ApiHelper", context.getString(R.string.failed_to_refresh_token_login_again));
                                    errorListener.onErrorResponse(error);
                                    ReparaTechSingleton.getInstance(context).removeAuth();
                                    e.printStackTrace();
                                }
                            } else {
                                errorListener.onErrorResponse(error);
                            }
                        } else {
                            Toast.makeText(context, R.string.unable_to_re_authenticate_please_login_again, Toast.LENGTH_SHORT).show();
                            errorListener.onErrorResponse(error);
                            ReparaTechSingleton.getInstance(context).removeAuth();
                        }
                    }
                }
        ) {
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                return ReparaTechSingleton.getInstance(context).getAuthHeaders();
            }
        };

        requestQueue.add(request);
    }
}
