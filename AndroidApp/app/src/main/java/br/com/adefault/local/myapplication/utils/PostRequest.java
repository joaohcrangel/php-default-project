package br.com.adefault.local.myapplication.utils;

import android.content.Context;
import android.util.Log;

import com.android.volley.AuthFailureError;
import com.android.volley.NetworkError;
import com.android.volley.NetworkResponse;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Map;

import br.com.adefault.local.myapplication.models.User;

public class PostRequest {

    private StringRequest request;

    public StringRequest getRequest(){

        return request;

    }

    public PostRequest(Context cx, String url, final Map<String,String> params, final Callback r) {

        RequestQueue queue = Volley.newRequestQueue(cx);
        String token = User.getToken(cx);

        if (!token.isEmpty()) {
            url += "?token="+token;
        }

        request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

                Log.d("DEBUG", response);

                JSONObject result = null;

                try {
                    result = new JSONObject(response);
                } catch (JSONException e) {
                    e.printStackTrace();
                }

                r.run(true, result);

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

                JSONObject result = new JSONObject();
                NetworkResponse response = error.networkResponse;

                try {

                    result.put("success", false);

                    if(response != null && response.data != null) {

                        result = new JSONObject(new String(response.data));
                        Log.d("DEBUG", new String(response.data));
                        Log.e("DEBUG", result.getString("error"));

                    } else {

                        if (error instanceof TimeoutError) {
                            result.put("error", "Timeout");
                        } else if (error instanceof NoConnectionError) {
                            result.put("error", "NoConnection");
                        } else if (error instanceof AuthFailureError) {
                            result.put("error", "AuthFailureError");
                        } else if (error instanceof ServerError) {
                            result.put("error", "ServerError");
                        } else if (error instanceof NetworkError) {
                            result.put("error", "NetworkError");
                        } else if (error instanceof ParseError) {
                            result.put("error", "ParseError");
                        }

                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }

                r.run(false, result);

            }

        }){

            @Override
            protected Map<String,String> getParams(){

                Log.d("DEBUG", "POST FIELDS:"+params.toString());

                return params;
            }

        };
        /*
        request.setRetryPolicy(new DefaultRetryPolicy(
                10000,
                DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
                DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        */
        Log.d("DEBUG", "POST: "+url);

        queue.add(request);

    }

}
