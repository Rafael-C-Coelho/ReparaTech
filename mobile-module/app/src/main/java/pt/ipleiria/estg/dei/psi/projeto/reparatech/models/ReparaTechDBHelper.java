package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import java.util.ArrayList;
import java.util.Collection;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;

public class ReparaTechDBHelper extends SQLiteOpenHelper {

    private static final String DB_NAME = "reparatech.db";
    private static final int DB_VERSION = 5;

    private SQLiteDatabase db;

    private static final String TABLE_PRODUCTS = "products";
    private static final String ID_PRODUCT = "id";
    private static final String NAME_PRODUCT = "name";
    private static final String PRICE_PRODUCT = "price";
    private static final String IMAGE_PRODUCT = "image";
    private static final String STOCK_PRODUCT = "stock";

    private static final String TABLE_CART_ITEMS = "cart_items";
    private static final String ID_CART_ITEM = "id";
    private static final String ID_PRODUCT_CART_ITEM = "id_product";
    private static final String QUANTITY_CART_ITEM = "quantity";

    private static final String TABLE_RECENTLYADDED_PRODUCT = "recently_added_products";
    private static final String ID_RECENTLYADDED_PRODUCT = "id";
    private static final String NAME_RECENTLYADDED_PRODUCT = "name";
    private static final String PRICE_RECENTLYADDED_PRODUCT = "price";
    private static final String IMAGE_RECENTLYADDED_PRODUCT = "image";
    private static final String STOCK_RECENTLYADDED_PRODUCT = "stock";

    private static final String TABLE_SETTINGS = "settings";
    private static final String URL = "url";

    private static final String TABLE_AUTH = "auth";
    private static final String ID_AUTH = "id";
    private static final String EMAIL_AUTH = "email";
    private static final String TOKEN_AUTH = "token";
    private static final String REFRESH_TOKEN = "refresh_token";

    private static final String TABLE_REPAIR_CATEGORIES_LIST = "repair_categories_list";
    private static final String ID_CATEGORIES_LIST = "id_categories_list";
    private static final String NAME_REPAIR_CATEGORIES = "name_repair_categories";
    private static final String DESCRIPTION = "description";
    private static final String IMAGE_REPAIR_CATEGORIES = "img_repair_categories";

    private static final String TABLE_REPAIR_CATEGORY_DETAIL = "repair_category_detail";
    private static final String ID_REPAIR_CATEGORY = "id";
    private static final String CATEGORIES_LIST_ID = "id_categories_list";
    private static final String MOBILE_SOLUTION = "mobile_solution";
    private static final String TABLET_SOLUTION = "tablet_solution";
    private static final String DESKTOP_LAPTOP_SOLUTION = "desktop_laptop_solution";
    private static final String WEARABLES_SOLUTION = "wearables_solution";

    private static final String TABLE_BOOKINGS = "bookings";
    private static final String ID_BOOKING = "id";
    private static final String DATE_BOOKING = "date";
    private static final String TIME_BOOKING = "time";
    private static final String STATUS_BOOKING = "status";

    private static final String TABLE_BEST_SELLING_PRODUCTS = "best_selling_product_table";
    private static final String ID_BEST_SELLING_PRODUCT = "id";
    private static final String NAME_BEST_SELLING_PRODUCT = "name";
    private static final String PRICE_BEST_SELLING_PRODUCT = "price";
    private static final String IMAGE_BEST_SELLING_PRODUCT = "image";

    private static final String TABLE_SALES_PRODUCTS = "sales_product_table";
    private static final String ID_SALES_PRODUCT = "id";
    private static final String PRODUCT_ID = "product_id";
    private static final String QUANTITY = "quantity";
    private static final String CREATED_AT_SALES = "created_at";
    private static final String TABLE_REPAIR_EMPLOYEE = "repairs_employee";
    private static final String ID_REPAIR_EMPLOYEE = "id";
    private static final String CLIENT_NAME_REPAIR_EMPLOYEE = "client_name";
    private static final String PROGRESS_REPAIR_EMPLOYEE = "progress";
    private static final String DESCRIPTION_REPAIR_EMPLOYEE = "description";
    private static final String DEVICE_REPAIR_EMPLOYEE = "device";

    private static final String TABLE_COMMENT = "comments";
    private static final String ID_COMMENT = "id";
    private static final String DESCRIPTION_COMMENT = "description";
    private static final String DATE_COMMENT = "date";
    private static final String TIME_COMMENT = "time";
    private static final String ID_REPAIR_COMMENT = "id_repair";

    public ReparaTechDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        this.db = getWritableDatabase();
    }

    @Override
    public void onConfigure(SQLiteDatabase db) {
        super.onConfigure(db);
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String createSettingsTable = "CREATE TABLE IF NOT EXISTS " + TABLE_SETTINGS +
                "(" + URL + " TEXT NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(createSettingsTable);

        String createAuthTable = "CREATE TABLE " + TABLE_AUTH +
                "(" + ID_AUTH + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                EMAIL_AUTH + " TEXT NOT NULL, " +
                TOKEN_AUTH + " TEXT NOT NULL, " +
                REFRESH_TOKEN + " TEXT NOT NULL" +
                ");";
        sqLiteDatabase.execSQL(createAuthTable);

        String createTableRepairCategoriesList = "CREATE TABLE IF NOT EXISTS " + TABLE_REPAIR_CATEGORIES_LIST +
                "(" + ID_CATEGORIES_LIST + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                NAME_REPAIR_CATEGORIES + " TEXT NOT NULL, " +
                DESCRIPTION + " TEXT NOT NULL, " +
                IMAGE_REPAIR_CATEGORIES + " INTEGER" + ");";
        sqLiteDatabase.execSQL(createTableRepairCategoriesList);
        insertInitialRepairCategoriesList(sqLiteDatabase);

        String createTableRepairCategoryDetail = "CREATE TABLE IF NOT EXISTS " + TABLE_REPAIR_CATEGORY_DETAIL +
                "(" + ID_REPAIR_CATEGORY + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                ID_CATEGORIES_LIST + " INTEGER NOT NULL, " +
                MOBILE_SOLUTION + " TEXT NOT NULL, " +
                TABLET_SOLUTION + " TEXT NOT NULL, " +
                DESKTOP_LAPTOP_SOLUTION + " TEXT NOT NULL, " +
                WEARABLES_SOLUTION + " TEXT NOT NULL, " +
                " FOREIGN KEY (" + CATEGORIES_LIST_ID + ") REFERENCES " + TABLE_REPAIR_CATEGORIES_LIST + "(" + ID_CATEGORIES_LIST + ")" +
                ");";
        sqLiteDatabase.execSQL(createTableRepairCategoryDetail);
        insertInitialRepairCategoryDetail(sqLiteDatabase);

        String createProductTable = "CREATE TABLE IF NOT EXISTS " + TABLE_PRODUCTS +
                "(" + ID_PRODUCT + " INTEGER PRIMARY KEY, " +
                NAME_PRODUCT + " TEXT NOT NULL, " +
                PRICE_PRODUCT + " DECIMAL NOT NULL, " +
                STOCK_PRODUCT + " INTEGER NOT NULL, " +
                IMAGE_PRODUCT + " TEXT" + ");";
        sqLiteDatabase.execSQL(createProductTable);
        // insertInitialProducts(sqLiteDatabase);

        String createCartItemsTable = "CREATE TABLE " + TABLE_CART_ITEMS +
                "(" + ID_CART_ITEM + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                ID_PRODUCT_CART_ITEM + " INTEGER NOT NULL, " +
                QUANTITY_CART_ITEM + " INTEGER NOT NULL, " +
                "FOREIGN KEY(" + ID_PRODUCT_CART_ITEM + ") REFERENCES products(id)" +
                ");";
        sqLiteDatabase.execSQL(createCartItemsTable);

        String createBestSellingProductTable = "CREATE TABLE IF NOT EXISTS " + TABLE_BEST_SELLING_PRODUCTS +
                "(" + ID_BEST_SELLING_PRODUCT + " INTEGER PRIMARY KEY, " +
                NAME_BEST_SELLING_PRODUCT + " TEXT NOT NULL, " +
                PRICE_BEST_SELLING_PRODUCT + " DECIMAL NOT NULL, " +
                IMAGE_BEST_SELLING_PRODUCT + " TEXT" + ");";
        sqLiteDatabase.execSQL(createBestSellingProductTable);
        //insertInitialBestSellingProducts(sqLiteDatabase);

        String createRecentlyAddedProductTable = "CREATE TABLE IF NOT EXISTS " + TABLE_RECENTLYADDED_PRODUCT +
                "(" + ID_RECENTLYADDED_PRODUCT + " INTEGER PRIMARY KEY, " +
                NAME_RECENTLYADDED_PRODUCT + " TEXT NOT NULL, " +
                PRICE_RECENTLYADDED_PRODUCT + " DECIMAL NOT NULL, " +
                STOCK_RECENTLYADDED_PRODUCT + " INTEGER NOT NULL, " +
                IMAGE_RECENTLYADDED_PRODUCT + " TEXT" + ");";
        sqLiteDatabase.execSQL(createRecentlyAddedProductTable);

        String createBookingTable = "CREATE TABLE IF NOT EXISTS " + TABLE_BOOKINGS +
                "(" + ID_BOOKING + " INTEGER PRIMARY KEY, " +
                DATE_BOOKING + " TEXT NOT NULL, " +
                TIME_BOOKING + " TEXT NOT NULL, " +
                STATUS_BOOKING + " TEXT NOT NULL " + ");";
        sqLiteDatabase.execSQL(createBookingTable);

        String createRepairEmployee = "CREATE TABLE IF NOT EXISTS " + TABLE_REPAIR_EMPLOYEE +
                "(" + ID_REPAIR_EMPLOYEE + " INTEGER PRIMARY KEY, " +
                CLIENT_NAME_REPAIR_EMPLOYEE + " TEXT NOT NULL, " +
                PROGRESS_REPAIR_EMPLOYEE + " TEXT NOT NULL, " +
                DEVICE_REPAIR_EMPLOYEE + " TEXT NOT NULL, " +
                DESCRIPTION_REPAIR_EMPLOYEE + " TEXT NOT NULL " + ");";
        sqLiteDatabase.execSQL(createRepairEmployee);

        String createCommentTable = "CREATE TABLE IF NOT EXISTS " + TABLE_COMMENT +
                "(" + ID_COMMENT + " INTEGER PRIMARY KEY, " +
                DESCRIPTION_COMMENT + " TEXT NOT NULL, " +
                DATE_COMMENT + " TEXT NOT NULL, " +
                TIME_COMMENT + " TEXT NOT NULL, " +
                ID_REPAIR_COMMENT + " INTEGER NOT NULL, " +
                "FOREIGN KEY(" + ID_REPAIR_COMMENT + ") REFERENCES " + TABLE_REPAIR_EMPLOYEE + "(" + ID_REPAIR_EMPLOYEE + ")" +
                ");";
        sqLiteDatabase.execSQL(createCommentTable);

        String createSalesProductTable = "CREATE TABLE " + TABLE_SALES_PRODUCTS +
                " (" + ID_SALES_PRODUCT + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                PRODUCT_ID + " INTEGER NOT NULL, " +
                QUANTITY + " INTEGER NOT NULL, " +
                CREATED_AT_SALES + " TIMESTAMP DEFAULT CURRENT_TIMESTAMP" + ");";
        sqLiteDatabase.execSQL(createSalesProductTable);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_SETTINGS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_AUTH);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_RECENTLYADDED_PRODUCT);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_PRODUCTS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_REPAIR_CATEGORIES_LIST);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_REPAIR_CATEGORY_DETAIL);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_CART_ITEMS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_BOOKINGS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_BEST_SELLING_PRODUCTS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_SALES_PRODUCTS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_REPAIR_EMPLOYEE);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_COMMENT);
        onCreate(db);
    }

    // region # SETTINGS METHODS #

    public void addSettingsDB(Settings settings) {
        ContentValues values = new ContentValues();
        values.put(URL, settings.getUrl());

        this.db.insert(TABLE_SETTINGS, null, values);
    }

    public Settings getSettingsDB() {
        Cursor cursor = this.db.query(TABLE_SETTINGS, new String[]{URL},
                null,
                null,
                null,
                null,
                null);

        if (cursor.moveToLast()) {
            return new Settings(cursor.getString(0));
        }
        return null;
    }

    public void updateSettingsDB(Settings settings) {
        ContentValues values = new ContentValues();
        values.put(URL, settings.getUrl());

        this.db.update(TABLE_SETTINGS, values, null, null);
    }

    // endregion

    // region # AUTH METHODS #

    public void addAuthDB(Auth auth) {
        ContentValues values = new ContentValues();
        values.put(EMAIL_AUTH, auth.getEmail());
        values.put(TOKEN_AUTH, auth.getToken());
        values.put(REFRESH_TOKEN, auth.getRefreshToken());

        this.db.insert(TABLE_AUTH, null, values);
    }

    public Auth getAuthDB() {
        Cursor cursor = this.db.query(TABLE_AUTH, new String[]{EMAIL_AUTH, TOKEN_AUTH, REFRESH_TOKEN},
                null,
                null,
                null,
                null,
                null);

        if (cursor.moveToLast()) {
            return new Auth(cursor.getString(0), cursor.getString(1), cursor.getString(2));
        }
        return null;
    }

    public void updateAuthDB(Auth auth) {
        ContentValues values = new ContentValues();
        values.put(EMAIL_AUTH, auth.getEmail());
        values.put(TOKEN_AUTH, auth.getToken());
        values.put(REFRESH_TOKEN, auth.getRefreshToken());

        this.db.update(TABLE_AUTH, values, null, null);
    }

    public void removeAllAuthDB() {
        this.db.delete(TABLE_AUTH, null, null);
    }

    // endregion


    // region # PRODUCTS METHODS #

    public ArrayList<Product> getAllProductsDB() {
        ArrayList<Product> products = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_PRODUCTS, new String[]{ID_PRODUCT, NAME_PRODUCT, PRICE_PRODUCT, IMAGE_PRODUCT, STOCK_PRODUCT}, null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                Product product = new Product(cursor.getInt(0), cursor.getString(1), cursor.getDouble(2), cursor.getString(3), cursor.getInt(4));
                products.add(product);
            } while (cursor.moveToNext());
        }
        return products;
    }

    public void addProductsDB(ArrayList<Product> products) {
        for (Product product : products) {
            ContentValues values = new ContentValues();
            values.put(ID_PRODUCT, product.getId());
            values.put(NAME_PRODUCT, product.getName());
            values.put(PRICE_PRODUCT, product.getPrice());
            values.put(IMAGE_PRODUCT, product.getImage());
            values.put(STOCK_PRODUCT, product.getStock());

            this.db.insert(TABLE_PRODUCTS, null, values);
        }
    }

    public void removeProductsDB() {
        this.db.delete(TABLE_PRODUCTS, null, null);
    }

    public ArrayList<Product> getAllRecentlyAddedProductsDB() {
        ArrayList<Product> products = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_RECENTLYADDED_PRODUCT, new String[]{ID_RECENTLYADDED_PRODUCT, NAME_RECENTLYADDED_PRODUCT, PRICE_RECENTLYADDED_PRODUCT, IMAGE_RECENTLYADDED_PRODUCT, STOCK_RECENTLYADDED_PRODUCT}, null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                Product product = new Product(cursor.getInt(0), cursor.getString(1), cursor.getDouble(2), cursor.getString(3), cursor.getInt(4));
                products.add(product);
            } while (cursor.moveToNext());
        }
        return products;
    }

    // endregion

    // region # RECENTLY ADDED PRODUCTS METHODS #

    public void addRecentlyAddedProductsDB(ArrayList<Product> products) {
        for (Product product : products) {
            ContentValues values = new ContentValues();
            values.put(ID_RECENTLYADDED_PRODUCT, product.getId());
            values.put(NAME_RECENTLYADDED_PRODUCT, product.getName());
            values.put(PRICE_RECENTLYADDED_PRODUCT, product.getPrice());
            values.put(IMAGE_RECENTLYADDED_PRODUCT, product.getImage());
            values.put(STOCK_RECENTLYADDED_PRODUCT, product.getStock());

            this.db.insert(TABLE_RECENTLYADDED_PRODUCT, null, values);
        }
    }

    public void removeRecentlyAddedProductsDB() {
        this.db.delete(TABLE_RECENTLYADDED_PRODUCT, null, null);
    }

    // endregion

    // region # BEST SELLING PRODUCTS METHODS #

    public void addBestSellingProductsDB(ArrayList<BestSellingProduct> products) {
        for (BestSellingProduct product : products) {
            ContentValues values = new ContentValues();
            values.put(ID_BEST_SELLING_PRODUCT, product.getId());
            values.put(NAME_BEST_SELLING_PRODUCT, product.getName());
            values.put(PRICE_BEST_SELLING_PRODUCT, product.getPrice());
            values.put(IMAGE_BEST_SELLING_PRODUCT, product.getImage());

            this.db.insert(TABLE_BEST_SELLING_PRODUCTS, null, values);
        }
    }

    public void removeBestSellingProductsDB() {
        this.db.delete(TABLE_BEST_SELLING_PRODUCTS, null, null);
    }

    // endregion

    // region # CART ITEMS #
    public void addProductToCartDB(Product product, int quantity) {
        ContentValues values = new ContentValues();
        for (CartItem alreadyCartItem : getAllCartItemsDB()) {
            if (alreadyCartItem.getIdProduct() == product.getId()) {
                updateCartItemDB(alreadyCartItem.getId(), quantity);
                return;
            }
        }
        values.put(ID_PRODUCT_CART_ITEM, product.getId());
        values.put(QUANTITY_CART_ITEM, quantity);

        this.db.insert(TABLE_CART_ITEMS, null, values);
    }


    public ArrayList<CartItem> getAllCartItemsDB() {
        ArrayList<CartItem> cartItems = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_CART_ITEMS,
                new String[]{ID_CART_ITEM, ID_PRODUCT_CART_ITEM, QUANTITY_CART_ITEM},
                null, null, null, null, null);
        if (cursor.moveToFirst()) {
            do {
                CartItem cartItem = new CartItem(
                        cursor.getInt(0),    // id
                        cursor.getInt(1),    // id_product
                        cursor.getInt(2)     // quantity
                );
                cartItems.add(cartItem);
            } while (cursor.moveToNext());
        }

        cursor.close();
        return cartItems;
    }

    public void addCartItemsDB(ArrayList<CartItem> cartItems) {
        for (CartItem cartItem : cartItems) {
            ContentValues values = new ContentValues();
            values.put(ID_CART_ITEM, cartItem.getId());
            for (CartItem alreadyCartItem : getAllCartItemsDB()) {
                if (alreadyCartItem.getIdProduct() == cartItem.getIdProduct()) {
                    updateCartItemDB(alreadyCartItem.getId(), cartItem.getQuantity());
                }
            }
            values.put(ID_PRODUCT_CART_ITEM, cartItem.getIdProduct());
            values.put(QUANTITY_CART_ITEM, cartItem.getQuantity());

            this.db.insert(TABLE_CART_ITEMS, null, values);
        }
    }

    public void updateCartItemDB(int id, int quantity) {
        ContentValues values = new ContentValues();
        values.put(QUANTITY_CART_ITEM, quantity);

        this.db.update(TABLE_CART_ITEMS, values, ID_CART_ITEM + " = ?", new String[]{String.valueOf(id)});
    }

    public void removeCartItemDB(int id) {
        this.db.delete(TABLE_CART_ITEMS, ID_CART_ITEM + " = ?", new String[]{String.valueOf(id)});
    }

    public void removeCartItemsDB() {
        this.db.delete(TABLE_CART_ITEMS, null, null);
    }


    public void removeProductFromCartDB(Product product) {
        this.db.delete(TABLE_CART_ITEMS, ID_PRODUCT_CART_ITEM + " = ?", new String[]{String.valueOf(product.getId())});
    }

    // endregion

    // region # REPAIR CATEGORIES LIST #
    private void insertInitialRepairCategoriesList(@NonNull SQLiteDatabase db) {
        ContentValues values = new ContentValues();
        values.put(NAME_REPAIR_CATEGORIES, "Audio");
        values.put(DESCRIPTION, "If your device does not transmit sounds, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Battery");
        values.put(DESCRIPTION, "If your device has battery damaged, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Buttons");
        values.put(DESCRIPTION, "If your device has some button damaged, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Broken Screen");
        values.put(DESCRIPTION, "If your device has a damaged screen, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Camera");
        values.put(DESCRIPTION, "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Connectivity");
        values.put(DESCRIPTION, "If your device has connectivity issues, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Data Recovery");
        values.put(DESCRIPTION, "Have you lost important data that you'd like to recover? Our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Hardware Cleaning");
        values.put(DESCRIPTION, "Do you want to carry out routine maintenance? Our team is ready to do it with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Liquid Damage");
        values.put(DESCRIPTION, "Has your device fallen into the pool and won't switch on? Our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Network");
        values.put(DESCRIPTION, "If your device has network issues, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Software");
        values.put(DESCRIPTION, "If your device has malicious software, our team is ready to solve the problem with the utmost efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Storage");
        values.put(DESCRIPTION, "If your device has storage issues, our team is ready to solve the problem with maximum efficiency.");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);

        values.put(NAME_REPAIR_CATEGORIES, "Repair Not Listed");
        values.put(DESCRIPTION, "If the anomaly is not listed, please contact us!");
        values.put(IMAGE_REPAIR_CATEGORIES, R.drawable.iphone_capa);
        db.insert(TABLE_REPAIR_CATEGORIES_LIST, null, values);
    }

    public ArrayList<RepairCategoriesList> getAllRepairCategoriesListDB() {
        ArrayList<RepairCategoriesList> repairCategoriesList = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_REPAIR_CATEGORIES_LIST, new String[]{ID_CATEGORIES_LIST, NAME_REPAIR_CATEGORIES, DESCRIPTION, IMAGE_REPAIR_CATEGORIES}, null, null, null, null, null);
        if (cursor.moveToFirst()) {
            do {
                RepairCategoriesList repairCategoryList = new RepairCategoriesList(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getInt(3));
                repairCategoriesList.add(repairCategoryList);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return repairCategoriesList;
    }

    public ArrayList<RepairCategoryDetail> getAllRepairCategoriesDetailsListDB() {
        ArrayList<RepairCategoryDetail> repairCategoriesDetailsList = new ArrayList<>();

        Cursor cursor = this.db.query(TABLE_REPAIR_CATEGORY_DETAIL, new String[]{ID_REPAIR_CATEGORY, MOBILE_SOLUTION, TABLET_SOLUTION, DESKTOP_LAPTOP_SOLUTION, WEARABLES_SOLUTION}, null, null, null, null, null);
        if (cursor.moveToFirst()) {
            do {
                RepairCategoryDetail repairCategoryDetail = new RepairCategoryDetail(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4));
                repairCategoriesDetailsList.add(repairCategoryDetail);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return repairCategoriesDetailsList;
    }

    // endregion

    // region # REPAIR CATEGORY DETAIL #

    private void insertInitialRepairCategoryDetail(SQLiteDatabase db) {
        ContentValues values = new ContentValues();
        values.put(ID_CATEGORIES_LIST, 1);
        values.put(MOBILE_SOLUTION, "Weak, distorted or absent sound.\n" +
                "Low volume or no sound during calls.\n" +
                "No sound during calls in speakerphone mode.\n" +
                "Microphone muted or muffled during calls.\n" +
                "Interruptions in connection to wireless audio devices.");
        values.put(TABLET_SOLUTION, "Weak, distorted or absent sound.\n" +
                "Strange noises during playback.\n" +
                "Interruptions in connection to wireless audio devices.\n" +
                "Poor sound quality via Bluetooth.\n" +
                "Does not capture sound or captures very low sound.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Strange noises during playback.\n" +
                "Weak, distorted or absent sound.\n" +
                "Interference or echo during video conferences.\n" +
                "Microphone muted or muffled during video calls.\n" +
                "Conflicts between third-party software and the operating system.");
        values.put(WEARABLES_SOLUTION, "Bugs in updates that affect audio.\n" +
                "Need for audio calibration.\n" +
                "Notifications, calls or voice commands not audible.\n" +
                "Audio is out of sync with the main device.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 2);
        values.put(MOBILE_SOLUTION, "Diagnosis and replacement of degraded batteries.\n" +
                "Repair the battery or charging ports.\n" +
                "Checking for possible faults in the battery's internal circuit.\n" +
                "Immediate replacement of swollen or damaged batteries to avoid the risk of explosion.");
        values.put(TABLET_SOLUTION, "Diagnosis and replacement of degraded batteries.\n" +
                "Repair the battery or charging ports.\n" +
                "Checking for possible faults in the battery's internal circuit.\n" +
                "Immediate replacement of swollen or damaged batteries to avoid the risk of explosion.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Battery not recognised by the system.\n" +
                "Replacing the battery with a new one after reaching the cycle limit.\n" +
                "Diagnosis of internal faults in the battery or cooling system.\n" +
                "Checking and repairing short circuits or replacing faulty batteries.");
        values.put(WEARABLES_SOLUTION, "Diagnosis and replacement of degraded batteries.\n" +
                "Repair the battery or charging ports.\n" +
                "Checking for possible faults in the battery's internal circuit.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 3);
        values.put(MOBILE_SOLUTION, "Replacing damaged or worn buttons.\n" +
                "Internal cleaning to remove dirt or dust that prevents operation.\n" +
                "Fingerprint sensor replacement.\n" +
                "Repair of internal connectors or flex cables.");
        values.put(TABLET_SOLUTION, "Replacing damaged or worn buttons.\n" +
                "Internal cleaning to remove dirt or dust that prevents operation.\n" +
                "Fingerprint sensor replacement.\n" +
                "Repair of internal connectors or flex cables.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Adjust or replace buttons for RGB lighting.\n" +
                "Power button with motherboard diagnostics and button replacement.\n" +
                "Replacing or adjusting the button mechanism.");
        values.put(WEARABLES_SOLUTION, "Replacing damaged or worn buttons.\n" +
                "Internal cleaning to remove dirt or dust that prevents operation.\n" +
                "Repair of internal connectors or flex cables.\n" +
                "Fingerprint sensor replacement.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 4);
        values.put(MOBILE_SOLUTION, "Cracked or physically damaged screen.\n" +
                "Partial or full unresponsiveness of the touchscreen.\n" +
                "Screen burn-in, permanent discoloration due to static images.\n" +
                "Display discoloration, like color issues like yellow/green tints or washed-out colors. \n" +
                "Dead zones, with specific areas on the screen not responding to touch.");
        values.put(TABLET_SOLUTION, "Cracked or damaged screen.\n" +
                "Touchscreen calibration issues.\n" +
                "Screen registering non-existent .\n" +
                "Screen stuck on a single image due to hardware/software problems.\n" +
                "Black screen (no display), often due to faulty cables or connectors.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Cracked or physically damaged screen.\n" +
                "Dead pixels or pixel bleeding like unresponsive pixels or areas on the screen.\n" +
                "Backlight failure, the screen appears dim or completely dark while the system works.\n" +
                "Flickering screen caused by loose connections, faulty drivers, or hardware issues.");
        values.put(WEARABLES_SOLUTION, "Cracked or scratched glass.\n" +
                "Random flashes or unstable brightness levels.\n" +
                "Low screen brightness or no display.\n" +
                "Partial or full unresponsiveness of the touchscreen.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 5);
        values.put(MOBILE_SOLUTION, "Camera does not open or freezes due to a problem with the camera software or application.\n" +
                "Camera blurry and smudged due to dirty or damaged lens.\n" +
                "Front or rear camera does not work due to faulty connector or camera module.\n" +
                "Autofocus does not work because the module is broken or stuck. \n" +
                "Hardware error transmitting messages like \"Camera not detected\" due to communication failures between the camera and the motherboard.");
        values.put(TABLET_SOLUTION, "Camera does not open or freezes due to a problem with the camera software or application.\n" +
                "Camera blurry and smudged due to dirty or damaged lens.\n" +
                "Front or rear camera does not work due to faulty connector or camera module.\n" +
                "Autofocus does not work because the module is broken or stuck..\n" +
                "Flash does not work or is out of calibration because the flash LED is synchronization problems between the flash and shutter.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Camera not detected due to outdated or incompatible driver.\n" +
                "Camera with black or frozen image due to poorly connected or damaged internal cable.\n" +
                "Built-in camera microphone not working due to problems with the driver or faults with the microphone cable.\n" +
                "USB connectivity problems (external cameras).");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 6);
        values.put(MOBILE_SOLUTION, "Bluetooth: failure to pair or maintain connection with other devices (e.g., headphones or car systems).\n" +
                "Broken internal Wi-Fi antenna or loose connections.\n" +
                "USB/charging ports like due to not recognized when connected to a computer.");
        values.put(TABLET_SOLUTION, "Bluetooth: range or unstable connections with accessories.\n" +
                "USB-C/Lightning Port: problems with external accessories (e.g., keyboards, hubs)." +
                "Incompatibility with peripheral connections like styluses.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "USB Ports: Non-functional ports due to damage or driver issues.\n" +
                "Peripheral Device Connectivity: Issues with keyboards, mice, or webcams.\n" +
                "Internal Expansion Cards: Faulty Bluetooth or Wi-Fi cards.");
        values.put(WEARABLES_SOLUTION, "Bluetooth Pairing: Connection drops frequently or fails to initiate.\n" +
                "NFC/Contactless Payments: Malfunctioning NFC chips.\n" +
                "Magnetic Charging: Intermittent connection with the charger.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 7);
        values.put(MOBILE_SOLUTION, "Frequent ‘storage full’ messages.\n" +
                "Unable to install or update applications.\n" +
                "Recovery of accidentally deleted files.\n" +
                "Replacing or expanding internal memory.\n" +
                "Backing up data to the cloud.");
        values.put(TABLET_SOLUTION, "Frequent ‘storage full’ messages.\n" +
                "Unable to install or update applications.\n" +
                "Recovery of accidentally deleted files.\n" +
                "Replacing or expanding internal memory.\n" +
                "Backing up data to the cloud.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Hard Disc Failure.\n" +
                "SSD Performance Problems.\n" +
                "Backup files to the cloud.\n" +
                "Insufficient Storage Space.");
        values.put(WEARABLES_SOLUTION, "Storage full or insufficient space due to apps, cache, or media files.\n" +
                "Synchronization failures with smartphones or cloud services.\n" +
                "Apps taking up unnecessary storage with large files or cache.\n" +
                "Data corruption in internal memory or during backups.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 8);
        values.put(MOBILE_SOLUTION, "Cleaning the screen and surfaces.\n" +
                "Cleaning ports and connectors.\n" +
                "Lubricating connectors.");
        values.put(TABLET_SOLUTION, "Cleaning the screen and surfaces.\n" +
                "Cleaning ports and connectors." +
                "Lubricating connectors.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Internal cleaning (fans, boards and components).\n" +
                "Lubrication of fans and components.\n" +
                "Cleaning connections (USB, HDMI...)\n" +
                "Cleaning the screen and keyboard.");
        values.put(WEARABLES_SOLUTION, "Cleaning the screen and sensors.\n" +
                "Wristband cleaning.\n" +
                "Button lubrication.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 9);
        values.put(MOBILE_SOLUTION, "Corrosion of connectors (charging port, headphone jack, SIM card slot).\n" +
                "Short circuits on the motherboard.\n" +
                "Screen damage (water stains or unresponsive touch).\n" +
                "Muffled or non-functioning microphone and speaker.\n" +
                "Swollen or non-charging battery.");
        values.put(TABLET_SOLUTION, "Touchscreen malfunction or water stains.\n" +
                "Damaged charging or audio ports." +
                "Logic board issues due to liquid seepage.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Spills on keyboards or mice.\n" +
                "Corrosion on internal connectors, such as RAM or CPU slots.\n" +
                "Damaged power supply or motherboard.");
        values.put(WEARABLES_SOLUTION, "Audio and vibration issues.\n" +
                "Corrosion on magnetic charging connectors.\n" +
                "Touchscreen faults.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 10);
        values.put(MOBILE_SOLUTION, "Errors in the configuration of mobile data or Wi-Fi.\n" +
                "Problems with the device's internal aerial, affecting internet reception.\n" +
                "Internet access failures caused by misconfigured software updates.\n" +
                "Configuring or repairing VPN problems.\n" +
                "Diagnosis and resolution of Wi-Fi signal interference.");
        values.put(TABLET_SOLUTION, "Errors in the configuration of mobile data or Wi-Fi.\n" +
                "Problems with the device's internal aerial, affecting internet reception.\n" +
                "Internet access failures caused by misconfigured software updates.\n" +
                "Configuring or repairing VPN problems.\n" +
                "Diagnosis and resolution of Wi-Fi signal interference.");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Incorrect DNS or IP configuration preventing internet access.\n" +
                "Wi-Fi or Ethernet network adapter not working (replacement or repair).\n" +
                "Internet interruptions caused by outdated or corrupted network drivers.\n" +
                "Malware that blocks internet access or redirects browsing.\n" +
                "Firmware or configuration problems with the router/modem.");
        values.put(WEARABLES_SOLUTION, "Errors when synchronising internet via Wi-Fi.\n" +
                "Problems accessing the internet due to software configuration faults.\n" +
                "Firmware updates that failed to connect to servers.\n" +
                "Difficulty sharing internet from mobile devices.\n" +
                "Intermittent connection on public or home networks.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 11);
        values.put(MOBILE_SOLUTION, "Software updates (Android and iOS).\n" +
                "System restore and factory reset.\n" +
                "Fixing problems with applications.\n" +
                "Virus and malware removal.\n" +
                "Unlocking devices (PIN, pattern, account).");
        values.put(TABLET_SOLUTION, "Software updates (Android and iOS).\n" +
                "System restore and factory reset.\n" +
                "Fixing problems with applications.\n" +
                "Virus and malware removal.\n" +
                "Unlocking devices (PIN, pattern, account).");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Operating system errors (Windows, macOS, Linux).\n" +
                "Blue screen (BSOD) or boot errors..\n" +
                "Updating or installing operating systems.\n" +
                "Virus and malware removal.\n" +
                "Software installation and configuration.");
        values.put(WEARABLES_SOLUTION, "Software updates that fail or crash.\n" +
                "Bug fixes for wearable operating systems.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);

        values.put(ID_CATEGORIES_LIST, 12);
        values.put(MOBILE_SOLUTION, "Data recovery and/or replacement of microSD cards.\n" +
                "Cleaning the memory manually or using specialised tools.\n" +
                "Repair or replacement in case of internal storage failure (eMMC or UFS).");
        values.put(TABLET_SOLUTION, "Data recovery and/or replacement of microSD cards.\n" +
                "Cleaning the memory manually or using specialised tools.\n" +
                "Repair or replacement in case of internal storage failure (eMMC or UFS).");
        values.put(DESKTOP_LAPTOP_SOLUTION, "Diagnosis and replacement of a damaged Hard Disk Drive (HDD) or SSD.\n" +
                "Bad sectors on hard drives with Logical Repair (software) or physical replacement.\n" +
                "Installation of larger or faster discs (NVMe SSD, for example).\n" +
                "Disc-related boot problems such as operating system not found or boot failures.\n" +
                "Damaged SATA or NVMe connections are repaired or components replaced.");
        values.put(WEARABLES_SOLUTION, "Freeing up space and reconfiguring synchronisation in the event of limited storage for data synchronisation.\n" +
                "Reinstalling or updating the device's software.\n" +
                "Failed to recognise internal or connected storage.");
        db.insert(TABLE_REPAIR_CATEGORY_DETAIL, null, values);
    }

    public RepairCategoryDetail getRepairCategoryDetail(int idCategory) {
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.query(TABLE_REPAIR_CATEGORY_DETAIL, null, ID_REPAIR_CATEGORY + " = ?", new String[]{String.valueOf(idCategory)}, null, null, null);

        if (cursor != null && cursor.moveToFirst()) {
            int mobileSolutionIndex = cursor.getColumnIndex(MOBILE_SOLUTION);
            int tabletSolutionIndex = cursor.getColumnIndex(TABLET_SOLUTION);
            int desktopLaptopSolutionIndex = cursor.getColumnIndex(DESKTOP_LAPTOP_SOLUTION);
            int wearablesSolutionIndex = cursor.getColumnIndex(WEARABLES_SOLUTION);

            if (mobileSolutionIndex >= 0 && tabletSolutionIndex >= 0 && desktopLaptopSolutionIndex >= 0 && wearablesSolutionIndex >= 0) {
                String mobileSolution = cursor.getString(mobileSolutionIndex);
                String tabletSolution = cursor.getString(tabletSolutionIndex);
                String desktopLaptopSolution = cursor.getString(desktopLaptopSolutionIndex);
                String wearablesSolution = cursor.getString(wearablesSolutionIndex);
                cursor.close();
                return new RepairCategoryDetail(idCategory, mobileSolution, tabletSolution, desktopLaptopSolution, wearablesSolution);
            }
        }
        if (cursor != null) {
            cursor.close();
        }
        return null;
    }

    // endregion

    //region # BOOKINGS #

    public ArrayList<MyBooking> getAllBookingsDB(){
        ArrayList<MyBooking> myBookings = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_BOOKINGS, new String[]{ID_BOOKING, DATE_BOOKING, TIME_BOOKING, STATUS_BOOKING}, null, null,null, null, null);
        if (cursor.moveToFirst()){
            do {
                MyBooking myBooking = new MyBooking(cursor.getInt(0), cursor.getString(1), cursor.getString(2),cursor.getString(3));
                myBookings.add(myBooking);
            } while (cursor.moveToNext());
        }
        return myBookings;
    }

    public void addBookingsDB(ArrayList<MyBooking> myBookings){
        for (MyBooking myBooking : myBookings) {
            ContentValues values = new ContentValues();
            for (MyBooking alreadyBooked : getAllBookingsDB()) {
                if (alreadyBooked.getId() == myBooking.getId()) {
                    updateBookingDB(alreadyBooked.getId(), myBooking.getStatus());
                    return;
                }
            }
            values.put(ID_BOOKING, myBooking.getId());
            values.put(DATE_BOOKING, myBooking.getDate().toString());
            values.put(TIME_BOOKING, myBooking.getTime().toString());
            values.put(STATUS_BOOKING, myBooking.getStatus());

            this.db.insert(TABLE_BOOKINGS, null,values);
        }
    }

    public void updateBookingDB(int id, String status){
            ContentValues values = new ContentValues();
            values.put(STATUS_BOOKING, status);
            this.db.update(TABLE_BOOKINGS, values, ID_BOOKING + " = ?", new String[]{String.valueOf(id)});
    }

    public void removeBookingsDB() {
        this.db.delete(TABLE_BOOKINGS, null, null);
    }

    // endregion


    public void addBestSellingProductDB(ArrayList<BestSellingProduct> products) {
        for (BestSellingProduct product : products) {
            ContentValues values = new ContentValues();
            values.put(ID_BEST_SELLING_PRODUCT, product.getId());
            values.put(NAME_BEST_SELLING_PRODUCT, product.getName());
            values.put(PRICE_BEST_SELLING_PRODUCT, product.getPrice());
            values.put(IMAGE_BEST_SELLING_PRODUCT, product.getImage());
            this.db.insert(TABLE_BEST_SELLING_PRODUCTS, null, values);
        }
    }

    public ArrayList<BestSellingProduct> getAllBestSellingProductsDB() {
        ArrayList<BestSellingProduct> bestSellingProducts = new ArrayList<>();
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor cursor = db.query(TABLE_BEST_SELLING_PRODUCTS,
                new String[]{ID_BEST_SELLING_PRODUCT, NAME_BEST_SELLING_PRODUCT,IMAGE_BEST_SELLING_PRODUCT, PRICE_BEST_SELLING_PRODUCT, },
                null, null, null, null, null);
        if (cursor.moveToFirst()) {
            do {
                BestSellingProduct product = new BestSellingProduct(
                        cursor.getInt(0),
                        cursor.getString(1),
                        cursor.getString(2),
                        cursor.getDouble(3));
                bestSellingProducts.add(product);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return bestSellingProducts;
    }
        // region # Repair Employee #


    public ArrayList<? extends RepairEmployee> getAllRepairEmployeeDB(){
        ArrayList<RepairEmployee> repairEmployees = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_REPAIR_EMPLOYEE, new String[]{ID_REPAIR_EMPLOYEE, CLIENT_NAME_REPAIR_EMPLOYEE, PROGRESS_REPAIR_EMPLOYEE, DESCRIPTION_REPAIR_EMPLOYEE, DEVICE_REPAIR_EMPLOYEE}, null, null, null, null, null);
        if (cursor.moveToFirst()){
            do {
                RepairEmployee repairEmployee = new RepairEmployee(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getString(4));
                repairEmployees.add(repairEmployee);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return repairEmployees;
    }

    public void addRepairsEmployeeDB(ArrayList<RepairEmployee> repairEmployees){
        for (RepairEmployee repairEmployee : repairEmployees) {
            ContentValues values = new ContentValues();
            for (RepairEmployee alreadyRepairEmployee : getAllRepairEmployeeDB()) {
                if (alreadyRepairEmployee.getId() == repairEmployee.getId()) {
                    updateRepairEmployeeDB(alreadyRepairEmployee.getId(), repairEmployee.getProgress());
                    return;
                }
            }
            addRepairEmployeeDB(repairEmployee);
        }
    }

    public void addRepairEmployeeDB(RepairEmployee repairEmployee){
        ContentValues values = new ContentValues();
        for (RepairEmployee alreadyRepairEmployee : getAllRepairEmployeeDB()) {
            if (alreadyRepairEmployee.getId() == repairEmployee.getId()) {
                updateRepairEmployeeDB(alreadyRepairEmployee.getId(), repairEmployee.getProgress());
                return;
            }
        }
        values.put(ID_REPAIR_EMPLOYEE, repairEmployee.getId());
        values.put(CLIENT_NAME_REPAIR_EMPLOYEE, repairEmployee.getClientName());
        values.put(PROGRESS_REPAIR_EMPLOYEE, repairEmployee.getProgress());
        values.put(DESCRIPTION_REPAIR_EMPLOYEE, repairEmployee.getDescription());
        values.put(DEVICE_REPAIR_EMPLOYEE, repairEmployee.getDevice());

        this.db.insert(TABLE_REPAIR_EMPLOYEE, null, values);
    }

    public void updateRepairEmployeeDB(int id, String progress){
        ContentValues values = new ContentValues();
        values.put(PROGRESS_REPAIR_EMPLOYEE, progress);
        this.db.update(TABLE_REPAIR_EMPLOYEE, values, ID_REPAIR_EMPLOYEE + " = ?", new String[]{String.valueOf(id)});
    }

    public void removeAllRepairEmployeeDB(){
        this.db.delete(TABLE_REPAIR_EMPLOYEE, null, null);
    }

    // endregion

    // region # Comments #

    public ArrayList<Comment> getAllCommentsDB(){
        ArrayList<Comment> comments = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_COMMENT, new String[]{ID_COMMENT, DESCRIPTION_COMMENT, DATE_COMMENT, TIME_COMMENT, ID_REPAIR_COMMENT}, null, null, null, null, null);
        if (cursor.moveToFirst()){
            do {
                Comment comment = new Comment(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getInt(4));
                comments.add(comment);
            } while (cursor.moveToNext());
        }
        return comments;
    }

    public void addCommentsDB(ArrayList<Comment> comments){
        for (Comment comment : comments) {
            ContentValues values = new ContentValues();
            values.put(ID_COMMENT, comment.getId());
            values.put(DESCRIPTION_COMMENT, comment.getDescription());
            values.put(DATE_COMMENT, comment.getDate());
            values.put(TIME_COMMENT, comment.getTime());
            values.put(ID_REPAIR_COMMENT, comment.getIdRepair());

            this.db.insert(TABLE_COMMENT, null, values);
        }
    }

    public Comment getCommentById(int id){
        Cursor cursor = this.db.query(TABLE_COMMENT, new String[]{ID_COMMENT, DESCRIPTION_COMMENT, DATE_COMMENT, TIME_COMMENT, ID_REPAIR_COMMENT}, ID_COMMENT + " = ?", new String[]{String.valueOf(id)}, null, null, null);
        if (cursor != null && cursor.moveToFirst()){
            Comment comment = new Comment(cursor.getInt(0), cursor.getString(1), cursor.getString(2), cursor.getString(3), cursor.getInt(4));
            cursor.close();
            return comment;
        }
        if (cursor != null){
            cursor.close();
        }
        return null;
    }

    public void removeCommentsDB(){
        this.db.delete(TABLE_COMMENT, null, null);
    }

    public void addProductDB(Product product) {
        for (Product alreadyProduct : getAllProductsDB()) {
            if (alreadyProduct.getId() == product.getId()) {
                updateProductDB(product);
                return;
            }
        }
        ContentValues values = new ContentValues();
        values.put(ID_PRODUCT, product.getId());
        values.put(NAME_PRODUCT, product.getName());
        values.put(PRICE_PRODUCT, product.getPrice());
        values.put(IMAGE_PRODUCT, product.getImage());
        values.put(STOCK_PRODUCT, product.getImage());

        this.db.insert(TABLE_PRODUCTS, null, values);
    }

    private void updateProductDB(Product product) {
        ContentValues values = new ContentValues();
        values.put(NAME_PRODUCT, product.getName());
        values.put(PRICE_PRODUCT, product.getPrice());
        values.put(IMAGE_PRODUCT, product.getImage());

        this.db.update(TABLE_PRODUCTS, values, ID_PRODUCT + " = ?", new String[]{String.valueOf(product.getId())});
    }

    public void updateProductStock(int id, int stock) {
        ContentValues values = new ContentValues();
        values.put(STOCK_PRODUCT, stock);

        this.db.update(TABLE_PRODUCTS, values, ID_PRODUCT + " = ?", new String[]{String.valueOf(id)});
    }

    // endregion

    /*
    public void insertInitialBestSellingProducts(SQLiteDatabase db) {
        ContentValues values = new ContentValues();
        values.put(ID_BEST_SELLING_PRODUCT, 1);
        values.put(NAME_BEST_SELLING_PRODUCT, "Product 1");
        values.put(PRICE_BEST_SELLING_PRODUCT, 19.99);
        values.put(IMAGE_BEST_SELLING_PRODUCT, "image1.png");
        db.insert(TABLE_BEST_SELLING_PRODUCTS, null, values);

        values.put(ID_BEST_SELLING_PRODUCT, 2);
        values.put(NAME_BEST_SELLING_PRODUCT, "Product 2");
        values.put(PRICE_BEST_SELLING_PRODUCT, 29.99);
        values.put(IMAGE_BEST_SELLING_PRODUCT, "image2.png");
        db.insert(TABLE_BEST_SELLING_PRODUCTS, null, values);

        values.put(ID_BEST_SELLING_PRODUCT, 3);
        values.put(NAME_BEST_SELLING_PRODUCT, "Product 3");
        values.put(PRICE_BEST_SELLING_PRODUCT, 39.99);
        values.put(IMAGE_BEST_SELLING_PRODUCT, "image3.png");
        db.insert(TABLE_BEST_SELLING_PRODUCTS, null, values);
    }
     */
}
