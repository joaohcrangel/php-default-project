package br.com.adefault.local.myapplication.models;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

import com.google.gson.Gson;

import org.json.JSONObject;

import br.com.adefault.local.myapplication.db.DbHelper;
import br.com.adefault.local.myapplication.db.contracts.PersonContract;

public class Person {

    private Context cx;

    private long _ID;
    private long idperson;
    private String desperson;
    private String desname;
    private String desfirstname;
    private String deslastname;
    private long idpersontype;
    private String despersontype;
    private String desuser;
    private String despassword;
    private long iduser;
    private Boolean inblocked;
    private String desemail;
    private long idemail;
    private String desphone;
    private long idphone;
    private String descpf;
    private long idcpf;
    private String descnpj;
    private long idcnpj;
    private String desrg;
    private long idrg;
    private String dtupdate;
    private String desdtupdate;
    private String desweekdtupdate;
    private String desweekdaydtupdate;
    private String hrdtupdate;
    private String isodtupdate;
    private String tsupdate;
    private String dessex;
    private String dtbirth;
    private String desphoto;
    private Boolean inclient;
    private Boolean inprovider;
    private Boolean incollaborator;
    private long idaddress;
    private long idaddresstype;
    private String desaddresstype;
    private String desaddress;
    private String desnumber;
    private String desdistrict;
    private String descity;
    private String desstate;
    private String descountry;
    private String descep;
    private String descomplement;
    private String dtregister;
    private String desdtregister;
    private String desweekdtregister;
    private String desweekdaydtregister;
    private String hrdtregister;
    private String isodtregister;
    private String tsregister;
    private String tsdtupdate;
    private String desdtbirth;
    private String tsdtbirth;
    private String tsdtregister;
    private String desphotourl;

    public long get_ID() {
        return _ID;
    }

    public void set_ID(long _ID) {
        this._ID = _ID;
    }

    public long getIdperson() {
        return idperson;
    }

    public void setIdperson(long idperson) {
        this.idperson = idperson;
    }

    public String getDesperson() {
        return desperson;
    }

    public void setDesperson(String desperson) {
        this.desperson = desperson;
    }

    public String getDesname() {
        return desname;
    }

    public void setDesname(String desname) {
        this.desname = desname;
    }

    public String getDesfirstname() {
        return desfirstname;
    }

    public void setDesfirstname(String desfirstname) {
        this.desfirstname = desfirstname;
    }

    public String getDeslastname() {
        return deslastname;
    }

    public void setDeslastname(String deslastname) {
        this.deslastname = deslastname;
    }

    public long getIdpersontype() {
        return idpersontype;
    }

    public void setIdpersontype(long idpersontype) {
        this.idpersontype = idpersontype;
    }

    public String getDespersontype() {
        return despersontype;
    }

    public void setDespersontype(String despersontype) {
        this.despersontype = despersontype;
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

    public long getIduser() {
        return iduser;
    }

    public void setIduser(long iduser) {
        this.iduser = iduser;
    }

    public Boolean getInblocked() {
        return inblocked;
    }

    public void setInblocked(Boolean inblocked) {
        this.inblocked = inblocked;
    }

    public String getDesemail() {
        return desemail;
    }

    public void setDesemail(String desemail) {
        this.desemail = desemail;
    }

    public long getIdemail() {
        return idemail;
    }

    public void setIdemail(long idemail) {
        this.idemail = idemail;
    }

    public String getDesphone() {
        return desphone;
    }

    public void setDesphone(String desphone) {
        this.desphone = desphone;
    }

    public long getIdphone() {
        return idphone;
    }

    public void setIdphone(long idphone) {
        this.idphone = idphone;
    }

    public String getDescpf() {
        return descpf;
    }

    public void setDescpf(String descpf) {
        this.descpf = descpf;
    }

    public long getIdcpf() {
        return idcpf;
    }

    public void setIdcpf(long idcpf) {
        this.idcpf = idcpf;
    }

    public String getDescnpj() {
        return descnpj;
    }

    public void setDescnpj(String descnpj) {
        this.descnpj = descnpj;
    }

    public long getIdcnpj() {
        return idcnpj;
    }

    public void setIdcnpj(long idcnpj) {
        this.idcnpj = idcnpj;
    }

    public String getDesrg() {
        return desrg;
    }

    public void setDesrg(String desrg) {
        this.desrg = desrg;
    }

    public long getIdrg() {
        return idrg;
    }

    public void setIdrg(long idrg) {
        this.idrg = idrg;
    }

    public String getDtupdate() {
        return dtupdate;
    }

    public void setDtupdate(String dtupdate) {
        this.dtupdate = dtupdate;
    }

    public String getDesdtupdate() {
        return desdtupdate;
    }

    public void setDesdtupdate(String desdtupdate) {
        this.desdtupdate = desdtupdate;
    }

    public String getDesweekdtupdate() {
        return desweekdtupdate;
    }

    public void setDesweekdtupdate(String desweekdtupdate) {
        this.desweekdtupdate = desweekdtupdate;
    }

    public String getDesweekdaydtupdate() {
        return desweekdaydtupdate;
    }

    public void setDesweekdaydtupdate(String desweekdaydtupdate) {
        this.desweekdaydtupdate = desweekdaydtupdate;
    }

    public String getHrdtupdate() {
        return hrdtupdate;
    }

    public void setHrdtupdate(String hrdtupdate) {
        this.hrdtupdate = hrdtupdate;
    }

    public String getIsodtupdate() {
        return isodtupdate;
    }

    public void setIsodtupdate(String isodtupdate) {
        this.isodtupdate = isodtupdate;
    }

    public String getTsupdate() {
        return tsupdate;
    }

    public void setTsupdate(String tsupdate) {
        this.tsupdate = tsupdate;
    }

    public String getDessex() {
        return dessex;
    }

    public void setDessex(String dessex) {
        this.dessex = dessex;
    }

    public String getDtbirth() {
        return dtbirth;
    }

    public void setDtbirth(String dtbirth) {
        this.dtbirth = dtbirth;
    }

    public String getDesphoto() {
        return desphoto;
    }

    public void setDesphoto(String desphoto) {
        this.desphoto = desphoto;
    }

    public Boolean getInclient() {
        return inclient;
    }

    public void setInclient(Boolean inclient) {
        this.inclient = inclient;
    }

    public Boolean getInprovider() {
        return inprovider;
    }

    public void setInprovider(Boolean inprovider) {
        this.inprovider = inprovider;
    }

    public Boolean getIncollaborator() {
        return incollaborator;
    }

    public void setIncollaborator(Boolean incollaborator) {
        this.incollaborator = incollaborator;
    }

    public long getIdaddress() {
        return idaddress;
    }

    public void setIdaddress(long idaddress) {
        this.idaddress = idaddress;
    }

    public long getIdaddresstype() {
        return idaddresstype;
    }

    public void setIdaddresstype(long idaddresstype) {
        this.idaddresstype = idaddresstype;
    }

    public String getDesaddresstype() {
        return desaddresstype;
    }

    public void setDesaddresstype(String desaddresstype) {
        this.desaddresstype = desaddresstype;
    }

    public String getDesaddress() {
        return desaddress;
    }

    public void setDesaddress(String desaddress) {
        this.desaddress = desaddress;
    }

    public String getDesnumber() {
        return desnumber;
    }

    public void setDesnumber(String desnumber) {
        this.desnumber = desnumber;
    }

    public String getDesdistrict() {
        return desdistrict;
    }

    public void setDesdistrict(String desdistrict) {
        this.desdistrict = desdistrict;
    }

    public String getDescity() {
        return descity;
    }

    public void setDescity(String descity) {
        this.descity = descity;
    }

    public String getDesstate() {
        return desstate;
    }

    public void setDesstate(String desstate) {
        this.desstate = desstate;
    }

    public String getDescountry() {
        return descountry;
    }

    public void setDescountry(String descountry) {
        this.descountry = descountry;
    }

    public String getDescep() {
        return descep;
    }

    public void setDescep(String descep) {
        this.descep = descep;
    }

    public String getDescomplement() {
        return descomplement;
    }

    public void setDescomplement(String descomplement) {
        this.descomplement = descomplement;
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

    public String getTsdtupdate() {
        return tsdtupdate;
    }

    public void setTsdtupdate(String tsdtupdate) {
        this.tsdtupdate = tsdtupdate;
    }

    public String getDesdtbirth() {
        return desdtbirth;
    }

    public void setDesdtbirth(String desdtbirth) {
        this.desdtbirth = desdtbirth;
    }

    public String getTsdtbirth() {
        return tsdtbirth;
    }

    public void setTsdtbirth(String tsdtbirth) {
        this.tsdtbirth = tsdtbirth;
    }

    public String getTsdtregister() {
        return tsdtregister;
    }

    public void setTsdtregister(String tsdtregister) {
        this.tsdtregister = tsdtregister;
    }

    public String getDesphotourl() {
        return desphotourl;
    }

    public void setDesphotourl(String desphotourl) {
        this.desphotourl = desphotourl;
    }

    private void setJSONObject(JSONObject data){

        Log.d("DEBUG", "setJSONObject: "+data.toString());

        new Gson().fromJson(data.toString(), Person.class);

    }

    public Person(Context cx, long iduser){

        this.cx = cx;
        loadFromId(cx, iduser);

    }

    public Person(Context cx, JSONObject data){

        this.cx = cx;
        setJSONObject(data);

    }

    public Person(Context cx){

        this.cx = cx;

    }

    private void loadFromId(Context cx, long idperson){

        DbHelper dbhelper = new DbHelper(cx);

        SQLiteDatabase db = dbhelper.getReadableDatabase();

        Cursor c = db.rawQuery("SELECT * FROM "+ PersonContract.PersonEntry.TABLE_NAME+" WHERE "+ PersonContract.PersonEntry.COLUMN_NAME_IDPERSON+" = ?", new String[]{String.valueOf(idperson)});

        loadFromCurso(c);

    }

    private void loadFromCurso(Cursor c){

        if (c.getCount() > 0) {

            c.moveToFirst();

            setDescnpj(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESCNPJ)));
            setDescpf(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESCPF)));
            setDesemail(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESEMAIL)));
            setDesfirstname(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESFIRSTNAME)));
            setDeslastname(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESLASTNAME)));
            setDesname(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESNAME)));
            setDesperson(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESPERSON)));
            setDespersontype(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESPERSONTYPE)));
            setDesphone(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESPHONE)));
            setDesrg(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESRG)));
            setDessex(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DESSEX)));
            setDtbirth(c.getString(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_DTBIRTH)));
            setIdcnpj(c.getInt(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_IDCNPJ)));
            setIdcpf(c.getInt(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_IDCPF)));
            setIdemail(c.getInt(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_IDEMAIL)));
            setIdperson(c.getInt(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_IDPERSON)));
            setIdpersontype(c.getInt(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_IDPERSONTYPE)));
            setIdrg(c.getInt(c.getColumnIndex(PersonContract.PersonEntry.COLUMN_NAME_IDRG)));

            c.close();

        }

    }

    public void save(){

        DbHelper dbhelper = new DbHelper(cx);

        SQLiteDatabase db = dbhelper.getWritableDatabase();

        ContentValues values = new ContentValues();

        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESCNPJ, getDescnpj());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESCPF, getDescpf());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESEMAIL, getDesemail());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESFIRSTNAME, getDesfirstname());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESLASTNAME, getDeslastname());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESNAME, getDesname());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESPERSON, getDesperson());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESPERSONTYPE, getDespersontype());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESPHONE, getDesphone());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESPHOTO, getDesphoto());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESRG, getDesrg());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DESSEX, getDessex());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_DTBIRTH, getDtbirth());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_IDCNPJ, getIdcnpj());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_IDCPF, getIdcpf());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_IDEMAIL, getIdemail());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_IDPERSON, getIdperson());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_IDPERSONTYPE, getIdpersontype());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_IDPHONE, getIdphone());
        values.put(PersonContract.PersonEntry.COLUMN_NAME_IDRG, getIdrg());

        if (get_ID() > 0) {

            db.update(PersonContract.PersonEntry.TABLE_NAME, values, PersonContract.PersonEntry._ID+" = ?", new String[]{
                    String.valueOf(get_ID())
            });

        } else {

            set_ID(db.insert(PersonContract.PersonEntry.TABLE_NAME, null, values));

        }

    }


}
