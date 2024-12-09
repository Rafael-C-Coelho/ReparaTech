package pt.ipleiria.estg.dei.psi.projeto.reparatech.utils;

import android.content.Context;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

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

    public void makeRequest(
            Context context,
            int request_type,
            int method,
            String url,
            JSONObject body,
            Response.Listener<String> successListener,
            Response.ErrorListener errorListener
    ) {
        if (request_type == JSON_ARRAY_REQUEST) {
            makeJsonArrayRequest(method, url, body, successListener, errorListener);
        } else if (request_type == JSON_OBJECT_REQUEST) {
            makeJsonObjectRequest(method, url, body, successListener, errorListener);
        } else if (request_type == STRING_REQUEST) {
            makeStringRequest(method, url, body, successListener, errorListener);
        }
    }

    private static void makeJsonArrayRequest(
            int method,
            String url,
            JSONObject body,
            Response.Listener<String> successListener,
            Response.ErrorListener errorListener
    ) {
        StringRequest request = new StringRequest(
            method,
            url,
            successListener,
            errorListener
        );
        requestQueue.add(request);
    }

    private static void makeJsonObjectRequest(
            int method,
            String url,
            JSONObject body,
            Response.Listener<String> successListener,
            Response.ErrorListener errorListener
    ) {
        StringRequest request = new StringRequest(
            method,
            url,
            successListener,
            errorListener
        );
        requestQueue.add(request);
    }

    private static void makeStringRequest(
            int method,
            String url,
            JSONObject body,
            Response.Listener<String> successListener,
            Response.ErrorListener errorListener
    ) {
        StringRequest request = new StringRequest(
            method,
            url,
            successListener,
            errorListener
        );
        requestQueue.add(request);
    }
}
