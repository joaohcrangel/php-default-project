package br.com.adefault.local.myapplication.models;

import android.content.ContentValues;
import android.content.Context;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

import com.google.gson.Gson;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import br.com.adefault.local.myapplication.db.DbHelper;
import br.com.adefault.local.myapplication.db.contracts.UserContract;
import br.com.adefault.local.myapplication.utils.Callback;
import br.com.adefault.local.myapplication.utils.PostRequest;
import br.com.adefault.local.myapplication.utils.RequestConf;

public class User {

    private Context cx;

    public static final String KEY_PREFERENCES = "LOGGED" ;
    public static final String TOKEN = "token";
    public static final String IDUSER = "iduser";
    public static final String DESUSER = "user";
    public static final String DESPASSWORD = "password";
    public static final String IDPERSON = "idperson";

    private long _ID;
    private long iduser;
    private long idperson;
    private String desuser;
    private String despassword;
    private Boolean inblocked;
    private String dtregister;
    private String desdtregister;
    private String desweekdtregister;
    private String desweekdaydtregister;
    private String hrdtregister;
    private String isodtregister;
    private String tsregister;
    private long idusertype;
    private String despermissions;
    private Person person = null;

    final public static void login(final Context cx, String username, String password, final Callback cb){

        Map<String,String> fields = new HashMap<String,String>();

        fields.put("username", username);
        fields.put("password", password);

        Log.d("DEBUG", RequestConf.SERVER+"/users/login");

        PostRequest request = new PostRequest(cx, RequestConf.SERVER+"/users/login", fields, new Callback() {

            public void run(Boolean success, JSONObject result) {

            Log.d("DEBUG", "Run OK");

            if (success == true) {

                Log.d("DEBUG", "SharedPreferences");

                SharedPreferences sharedpreferences = cx.getSharedPreferences(KEY_PREFERENCES, Context.MODE_PRIVATE);

                SharedPreferences.Editor editor = sharedpreferences.edit();

                try {

                    JSONObject data = result.getJSONObject("data");
                    Log.d("DEBUG", "data: "+data.toString());
                    editor.putString(TOKEN, result.getString("token"));
                    editor.putLong(IDUSER, data.getLong("iduser"));
                    editor.putLong(IDPERSON, data.getLong("idperson"));
                    editor.putString(DESUSER, data.getString("desuser"));
                    editor.putString(DESPASSWORD, data.getString("despassword"));

                    JSONObject dataPerson = data.getJSONObject("Person");

                    Person person = new Person(cx, dataPerson);
                    person.save();

                    User newUser = new User(cx);
                    newUser.setJSONObject(data);
                    newUser.save();

                } catch (JSONException e) {
                    e.printStackTrace();
                }

                editor.commit();

            }

            cb.run(success, result);

            }
        });

    }

    final public void logout(Context cx){

        SharedPreferences sharedpreferences = cx.getSharedPreferences(KEY_PREFERENCES, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedpreferences.edit();
        editor.clear();
        editor.commit();

    }

    private void setJSONObject(JSONObject data){

        Log.d("DEBUG", "setJSONObject: "+data.toString());

        new Gson().fromJson(data.toString(), User.class);

    }

    public User(Context cx){

        this.cx = cx;

        SharedPreferences sharedpreferences = cx.getSharedPreferences(KEY_PREFERENCES, Context.MODE_PRIVATE);

        String password = sharedpreferences.getString(DESPASSWORD, "");
        String username = sharedpreferences.getString(DESUSER, "");
        long idperson = sharedpreferences.getLong(IDPERSON, 0);
        long iduser = sharedpreferences.getLong(IDUSER, 0);

        setDespassword(password);
        setDesuser(username);
        setIdperson(idperson);
        setIduser(iduser);

    }

    public User(Context cx, long iduser){

        this.cx = cx;
        loadFromId(cx, iduser);

    }

    private void loadFromId(Context cx, long iduser){

        DbHelper dbhelper = new DbHelper(cx);

        SQLiteDatabase db = dbhelper.getReadableDatabase();

        Cursor c = db.rawQuery("SELECT * FROM "+ UserContract.UserEntry.TABLE_NAME+" WHERE "+ UserContract.UserEntry.COLUMN_NAME_IDUSER+" = ?", new String[]{String.valueOf(iduser)});

        loadFromCurso(c);

    }

    private void loadFromCurso(Cursor c){

        if (c.getCount() > 0) {

            c.moveToFirst();

            setDespassword(c.getString(c.getColumnIndex(UserContract.UserEntry.COLUMN_NAME_DESPASSWORD)));
            setDesuser(c.getString(c.getColumnIndex(UserContract.UserEntry.COLUMN_NAME_DESUSER)));
            setIdperson(c.getLong(c.getColumnIndex(UserContract.UserEntry.COLUMN_NAME_IDPERSON)));
            setIduser(c.getLong(c.getColumnIndex(UserContract.UserEntry.COLUMN_NAME_IDUSER)));

            c.close();

        }

    }

    public void save(){

        DbHelper dbhelper = new DbHelper(cx);

        SQLiteDatabase db = dbhelper.getWritableDatabase();

        ContentValues values = new ContentValues();

        values.put(UserContract.UserEntry.COLUMN_NAME_DESPASSWORD, getDespassword());
        values.put(UserContract.UserEntry.COLUMN_NAME_DESUSER, getDesuser());
        values.put(UserContract.UserEntry.COLUMN_NAME_IDPERSON, getIdperson());
        values.put(UserContract.UserEntry.COLUMN_NAME_IDUSER, getIduser());

        if (get_ID() == 0 && getIduser() > 0) {

            Cursor c = db.rawQuery("SELECT * FROM "+UserContract.UserEntry.TABLE_NAME+" WHERE "+UserContract.UserEntry.COLUMN_NAME_IDUSER+" = ?", new String[]{String.valueOf(getIduser())});

            if (c.getCount() > 0) {

                c.moveToFirst();

                set_ID(c.getLong(c.getColumnIndex(UserContract.UserEntry._ID)));

            }

            c.close();

        }

        if (get_ID() > 0) {

            db.update(UserContract.UserEntry.TABLE_NAME, values, UserContract.UserEntry._ID+" = ?", new String[]{String.valueOf(get_ID())});

        } else {

            set_ID(db.insert(UserContract.UserEntry.TABLE_NAME, null, values));

        }

    }

    public Person getPerson() {

        person = new Person(cx, getIdperson());
        return person;

    }

    public static String getToken(Context cx){

        SharedPreferences sharedpreferences = cx.getSharedPreferences(KEY_PREFERENCES, Context.MODE_PRIVATE);

       return sharedpreferences.getString(TOKEN, "");

    }

    public long getIduser() {
        return iduser;
    }

    public void setIduser(long iduser) {
        this.iduser = iduser;
    }

    public long getIdperson() {
        return idperson;
    }

    public void setIdperson(long idperson) {
        this.idperson = idperson;
    }

    public String getDesuser() {
        return desuser;
    }

    public void setDesuser(String desuser) {
        this.desuser = desuser;
    }

    public String getDespassword() {
        return despassword;
    }

    public void setDespassword(String despassword) {
        this.despassword = despassword;
    }

    public Boolean getInblocked() {
        return inblocked;
    }

    public void setInblocked(Boolean inblocked) {
        this.inblocked = inblocked;
    }

    public String getDtregister() {
        return dtregister;
    }

    public void setDtregister(String dtregister) {
        this.dtregister = dtregister;
    }

    public String getDesdtregister() {
        return desdtregister;
    }

    public void setDesdtregister(String desdtregister) {
        this.desdtregister = desdtregister;
    }

    public String getDesweekdtregister() {
        return desweekdtregister;
    }

    public void setDesweekdtregister(String desweekdtregister) {
        this.desweekdtregister = desweekdtregister;
    }

    public String getDesweekdaydtregister() {
        return desweekdaydtregister;
    }

    public void setDesweekdaydtregister(String desweekdaydtregister) {
        this.desweekdaydtregister = desweekdaydtregister;
    }

    public String getHrdtregister() {
        return hrdtregister;
    }

    public void setHrdtregister(String hrdtregister) {
        this.hrdtregister = hrdtregister;
    }

    public String getIsodtregister() {
        return isodtregister;
    }

    public void setIsodtregister(String isodtregister) {
        this.isodtregister = isodtregister;
    }

    public String getTsregister() {
        return tsregister;
    }

    public void setTsregister(String tsregister) {
        this.tsregister = tsregister;
    }

    public long getIdusertype() {
        return idusertype;
    }

    public void setIdusertype(long idusertype) {
        this.idusertype = idusertype;
    }

    public String getDespermissions() {
        return despermissions;
    }

    public void setDespermissions(String despermissions) {
        this.despermissions = despermissions;
    }

    public void setPerson(Person person) {
        this.person = person;
    }

    public long get_ID() {
        return _ID;
    }

    public void set_ID(long _ID) {
        this._ID = _ID;
    }
}
