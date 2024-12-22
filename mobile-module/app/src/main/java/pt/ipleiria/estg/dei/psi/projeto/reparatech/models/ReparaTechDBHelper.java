package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;

public class ReparaTechDBHelper extends SQLiteOpenHelper {

    private static final String DB_NAME = "reparatech";
    private static final int DB_VERSION = 1;

    private final SQLiteDatabase db;

    private static final String TABLE_PRODUCTS = "products";
    private static final String ID_PRODUCT = "id";
    private static final String NAME_PRODUCT = "name";
    private static final String PRICE_PRODUCT = "price";
    private static final String IMAGE_PRODUCT = "image";

    private static final String TABLE_SETTINGS = "settings";
    private static final String URL = "url";

    private static final String TABLE_AUTH = "auth";
    private static final String USERNAME = "username";
    private static final String TOKEN = "token";
    private static final String REFRESH_TOKEN = "refresh_token";

    private static final String TABLE_REPAIR_CATEGORIES = "repair_categories";
    private static final String NAME = "name";

    public ReparaTechDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String createSettingsTable = "CREATE TABLE IF NOT EXISTS " + TABLE_SETTINGS +
                "(" + URL + " TEXT NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(createSettingsTable);

        String createAuthTable = "CREATE TABLE " + TABLE_AUTH +
                "(" + USERNAME + " TEXT NOT NULL, " +
                TOKEN + " TEXT NOT NULL, " +
                REFRESH_TOKEN + " TEXT NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(createAuthTable);

        String createRepairCategoriesTable = "CREATE TABLE IF NOT EXISTS" + TABLE_REPAIR_CATEGORIES +
                "(" + NAME + " TEXT NOT NULL, " +  ");";

        String createProductTable = "CREATE TABLE IF NOT EXISTS " + TABLE_PRODUCTS +
                                    "("+ ID_PRODUCT + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                                    NAME_PRODUCT + " TEXT NOT NULL, " +
                                    PRICE_PRODUCT + " DECIMAL NOT NULL, " +
                                    IMAGE_PRODUCT + " INTEGER" + ");";
        sqLiteDatabase.execSQL(createProductTable);
        insertInitialProducts(sqLiteDatabase);
    }

    
    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_SETTINGS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_AUTH);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_PRODUCTS);
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

        this.db.insert(TABLE_AUTH, null, values);
    }

    public Auth getAuthDB() {
        Cursor cursor = this.db.query(TABLE_AUTH,new String[]{USERNAME, TOKEN, REFRESH_TOKEN},
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

        this.db.update(TABLE_AUTH, values, null, null);
    }

    public void removeAllAuthDB() {
        this.db.delete(TABLE_AUTH, null, null);
    }

    // endregion

    // region # AUTH METHODS #

    // endregion

    // region # PRODUCTS METHODS #
    private void insertInitialProducts(SQLiteDatabase db) {
        ContentValues values = new ContentValues();

        values.put(NAME_PRODUCT, "Capa Iphone");
        values.put(PRICE_PRODUCT, 10);
        values.put(IMAGE_PRODUCT, R.drawable.iphone_capa);
        db.insert(TABLE_PRODUCTS, null, values);

        values.put(NAME_PRODUCT, "Capa Samsung");
        values.put(PRICE_PRODUCT, 12);
        values.put(IMAGE_PRODUCT, R.drawable.iphone_capa);
        db.insert(TABLE_PRODUCTS, null, values);

        values.put(NAME_PRODUCT, "Película de Ecrã Iphone 13");
        values.put(PRICE_PRODUCT, 15);
        values.put(IMAGE_PRODUCT, R.drawable.iphone_capa);
        db.insert(TABLE_PRODUCTS, null, values);

        values.put(NAME_PRODUCT, "Película de Ecrã Xiaomi Redmi Note 13");
        values.put(PRICE_PRODUCT, 15);
        values.put(IMAGE_PRODUCT, R.drawable.iphone_capa);
        db.insert(TABLE_PRODUCTS, null, values);

        values.put(NAME_PRODUCT, "Mochila ASUS para Laptop");
        values.put(PRICE_PRODUCT, 55);
        values.put(IMAGE_PRODUCT, R.drawable.iphone_capa);
        db.insert(TABLE_PRODUCTS, null, values);

        values.put(NAME_PRODUCT, "Rato Ergonómico Logitech");
        values.put(PRICE_PRODUCT, 85);
        values.put(IMAGE_PRODUCT, R.drawable.iphone_capa);
        db.insert(TABLE_PRODUCTS, null, values);
    }

    public ArrayList<Product> getAllProductsDB(){
        ArrayList<Product> products = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_PRODUCTS, new String[]{ID_PRODUCT ,NAME_PRODUCT, PRICE_PRODUCT, IMAGE_PRODUCT}, null, null, null, null, null);

        if(cursor.moveToFirst()){
            do{
                Product product = new Product(cursor.getInt(0),cursor.getString(1), cursor.getDouble(2), cursor.getInt(3));
                products.add(product);
            }while (cursor.moveToNext());
        }
        return products;
    }

    // endregion
}
