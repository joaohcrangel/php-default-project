package br.com.adefault.local.myapplication.utils;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import java.util.HashMap;
import java.util.Map;

public class PostRequest extends StringRequest {

    private Map<String,String> params;

    public PostRequest(String url, Map<String,String> params) {
        super(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });
        this.params = params;
    }

    @Override
    protected Map<String,String> getParams(){
        return params;
    }

}
