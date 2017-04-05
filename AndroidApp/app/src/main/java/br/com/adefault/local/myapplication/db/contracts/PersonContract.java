package br.com.adefault.local.myapplication.db.contracts;

import android.provider.BaseColumns;

public class PersonContract extends Contract {

    public PersonContract(){}

    public static class PersonEntry implements BaseColumns {
        public static final String TABLE_NAME = "persons";
        public static final String COLUMN_NAME_IDPERSON = "idperson";
        public static final String COLUMN_NAME_DESPERSON = "desperson";
        public static final String COLUMN_NAME_DESNAME = "desname";
        public static final String COLUMN_NAME_DESFIRSTNAME = "desfirstname";
        public static final String COLUMN_NAME_DESLASTNAME = "deslastname";
        public static final String COLUMN_NAME_IDPERSONTYPE = "idpersontype";
        public static final String COLUMN_NAME_DESPERSONTYPE = "despersontype";
        public static final String COLUMN_NAME_DESEMAIL = "desemail";
        public static final String COLUMN_NAME_IDEMAIL = "idemail";
        public static final String COLUMN_NAME_DESPHONE = "desphone";
        public static final String COLUMN_NAME_IDPHONE = "idphone";
        public static final String COLUMN_NAME_DESCPF = "descpf";
        public static final String COLUMN_NAME_IDCPF = "idcpf";
        public static final String COLUMN_NAME_DESCNPJ = "descnpj";
        public static final String COLUMN_NAME_IDCNPJ = "idcnpj";
        public static final String COLUMN_NAME_DESRG = "desrg";
        public static final String COLUMN_NAME_IDRG = "idrg";
        public static final String COLUMN_NAME_DESSEX = "dessex";
        public static final String COLUMN_NAME_DTBIRTH = "dtbirth";
        public static final String COLUMN_NAME_DESPHOTO = "desphoto";
    }

    public static final String SQL_CREATE_ENTRIES =
            "CREATE TABLE " + PersonContract.PersonEntry.TABLE_NAME + " (" +
                    PersonContract.PersonEntry._ID + LONG_TYPE + " PRIMARY KEY," +
                    PersonContract.PersonEntry.COLUMN_NAME_IDPERSON + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESPERSON + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESNAME + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESFIRSTNAME + INT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESLASTNAME + INT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_IDPERSONTYPE + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESPERSONTYPE + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESEMAIL + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_IDEMAIL + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESPHONE + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_IDPHONE + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESCPF + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_IDCPF + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESCNPJ + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_IDCNPJ + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESRG + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_IDRG + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESSEX + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DTBIRTH + TEXT_TYPE +
                    COMMA_SEP +
                    PersonContract.PersonEntry.COLUMN_NAME_DESPHOTO + TEXT_TYPE +
                    " )";

    public static final String SQL_DROP_ENTRIES =
            "DROP TABLE IF EXISTS " + PersonContract.PersonEntry.TABLE_NAME;

}