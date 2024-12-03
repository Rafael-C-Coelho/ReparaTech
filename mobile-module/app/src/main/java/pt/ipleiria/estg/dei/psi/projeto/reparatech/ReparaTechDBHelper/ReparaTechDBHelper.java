package pt.ipleiria.estg.dei.psi.projeto.reparatech.ReparaTechDBHelper;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

public class ReparaTechDBHelper extends SQLiteOpenHelper {

    private static final String DB_NAME = "reparatech";
    private static final int DB_VERSION = 1;

    private static final String TABLE_PRODUCTS = "products";
    private static final String NAME_PRODUCT = "name";
    private static final String PRICE_PRODUCT = "price";
    private static final String IMAGE_PRODUCT = "image";

    public ReparaTechDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        /*String createProductTable = "CREATE TABLE " + TABLE_PRODUCTS +
                                    "(" + NAME_PRODUCT + " TEXT "*/
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }
}
