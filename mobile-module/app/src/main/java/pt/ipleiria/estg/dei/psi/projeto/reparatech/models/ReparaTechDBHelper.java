package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

public class ReparaTechDBHelper extends SQLiteOpenHelper {

    private static final String DB_NAME = "reparatech";
    private static final int DB_VERSION = 1;

    private final SQLiteDatabase db;

    private static final String TABLE_PRODUCTS = "products";
    private static final String NAME_PRODUCT = "name";
    private static final String PRICE_PRODUCT = "price";
    private static final String IMAGE_PRODUCT = "image";

    private static final String TABLE_SETTINGS = "settings";
    private static final String URL = "url";

    private static final String TABLE_USERS = "auth";
    private static final String USERNAME = "username";
    private static final String TOKEN = "token";
    private static final String REFRESH_TOKEN = "refresh_token";

    public ReparaTechDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String createSettingsTable = "CREATE TABLE " + TABLE_SETTINGS +
                "(" + URL + " TEXT NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(createSettingsTable);

        String createAuthTable = "CREATE TABLE " + TABLE_USERS +
                "(" + USERNAME + " TEXT NOT NULL, " +
                TOKEN + " TEXT NOT NULL, " +
                REFRESH_TOKEN + " TEXT NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(createSettingsTable);

        /*String createProductTable = "CREATE TABLE " + TABLE_PRODUCTS +
                                    "(" + NAME_PRODUCT + " TEXT "*/
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_SETTINGS);
        this.onCreate(db);
    }

    // region # SETTINGS METHODS #

    public void addSettingsDB(Settings settings){
        ContentValues values = new ContentValues();
        values.put(URL, settings.getUrl());

        this.db.insert(TABLE_SETTINGS, null, values);
    }

    public Settings getSettingsDB(){
        Cursor cursor = this.db.query(TABLE_SETTINGS,new String[]{URL},
                null,
                null,
                null,
                null,
                null);

        if(cursor.moveToLast()){
            return new Settings(cursor.getString(0));
        }
        return null;
    }

    public void updateSettingsDB(Settings settings){
        ContentValues values = new ContentValues();
        values.put(URL, settings.getUrl());

        this.db.update(TABLE_SETTINGS, values, null, null);
    }

    // endregion

    // region # AUTH METHODS #

    public void addAuthDB(Auth auth) {
        ContentValues values = new ContentValues();
        values.put(USERNAME, auth.getUsername());
        values.put(TOKEN, auth.getToken());
        values.put(REFRESH_TOKEN, auth.getRefreshToken());

        this.db.insert(TABLE_USERS, null, values);
    }

    public Auth getAuthDB() {
        Cursor cursor = this.db.query(TABLE_USERS,new String[]{USERNAME, TOKEN, REFRESH_TOKEN},
                null,
                null,
                null,
                null,
                null);

        if(cursor.moveToLast()){
            return new Auth(cursor.getString(0), cursor.getString(1), cursor.getString(2));
        }
        return null;
    }

    public void updateAuthDB(Auth auth) {
        ContentValues values = new ContentValues();
        values.put(USERNAME, auth.getUsername());
        values.put(TOKEN, auth.getToken());
        values.put(REFRESH_TOKEN, auth.getRefreshToken());

        this.db.update(TABLE_USERS, values, null, null);
    }

    public void removeAllAuthDB() {
        this.db.delete(TABLE_USERS, null, null);
    }

    // endregion

    // region # AUTH METHODS #

    // endregion
}
