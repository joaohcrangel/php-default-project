package br.com.adefault.local.myapplication.db.contracts;

import android.provider.BaseColumns;

public class UserContract extends Contract {

    public UserContract(){}

    public static class UserEntry implements BaseColumns {
        public static final String TABLE_NAME = "users";
        public static final String COLUMN_NAME_IDUSER = "iduser";
        public static final String COLUMN_NAME_IDPERSON = "idperson";
        public static final String COLUMN_NAME_DESUSER = "desuser";
        public static final String COLUMN_NAME_DESPASSWORD = "despassword";
        public static final String COLUMN_NAME_INBLOCKED = "inblocked";
        public static final String COLUMN_NAME_IDUSERTYPE = "idusertype";
        public static final String COLUMN_NAME_DTREGISTER = "dtregister";
    }

    public static final String SQL_CREATE_ENTRIES =
            "CREATE TABLE " + UserEntry.TABLE_NAME + " (" +
                    UserEntry._ID + LONG_TYPE + " PRIMARY KEY," +
                    UserEntry.COLUMN_NAME_DESPASSWORD + TEXT_TYPE +
                    COMMA_SEP +
                    UserEntry.COLUMN_NAME_DESUSER + TEXT_TYPE +
                    COMMA_SEP +
                    UserEntry.COLUMN_NAME_DTREGISTER + TEXT_TYPE +
                    COMMA_SEP +
                    UserEntry.COLUMN_NAME_IDPERSON + INT_TYPE +
                    COMMA_SEP +
                    UserEntry.COLUMN_NAME_IDUSER + INT_TYPE +
                    COMMA_SEP +
                    UserEntry.COLUMN_NAME_IDUSERTYPE + INT_TYPE +
                    COMMA_SEP +
                    UserEntry.COLUMN_NAME_INBLOCKED + TEXT_TYPE +
                    " )";

    public static final String SQL_DROP_ENTRIES =
            "DROP TABLE IF EXISTS " + UserEntry.TABLE_NAME;

}