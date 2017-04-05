package br.com.adefault.local.myapplication.utils;

import org.json.JSONObject;

public interface Callback {

    public void run(Boolean success, JSONObject r);

}
