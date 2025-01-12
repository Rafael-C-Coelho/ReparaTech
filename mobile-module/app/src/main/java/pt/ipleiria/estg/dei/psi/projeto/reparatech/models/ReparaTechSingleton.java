package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.Context;
import android.widget.Toast;

import com.android.volley.NoConnectionError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.sql.SQLOutput;
import java.util.ArrayList;
import java.util.Map;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.BookingListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.LoginListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.RegisterListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateProductsListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers.MyBookingJsonParser;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers.ProductJsonParser;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.utils.ApiHelper;

public class ReparaTechSingleton {
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private ArrayList<RepairCategoriesList> repairCategoriesList;
    private ArrayList<Product> products;
    private ArrayList<MyBooking> myBookings;
    private static RequestQueue volleyQueue;
    private static ReparaTechSingleton INSTANCE = null;
    private Context context;
    private ReparaTechDBHelper dbHelper;
    private Settings settings;

    private LoginListener loginListener;
    private RegisterListener registerListener;
    private BookingListener bookingListener;
    private UpdateProductsListener updateProductsListener;

    private ReparaTechSingleton(Context context){
        products = new ArrayList<>();
        repairCategoriesList = new ArrayList<>();
        myBookings = new ArrayList<>();
        dbHelper = new ReparaTechDBHelper(context);
        settings = new Settings();

        this.context = context;
        // generateDinamicRepairCategories();
        // generateDinamicBestSellingProducts();
        // generateDinamicProducts();

    }

    public static synchronized ReparaTechSingleton getInstance(Context context){
        if(INSTANCE==null) {
            INSTANCE = new ReparaTechSingleton(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return INSTANCE;
    }

    public ReparaTechDBHelper getDbHelper() {
        return dbHelper;
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setRegisterListener(RegisterListener registerListener) {
        this.registerListener = registerListener;
    }

    public void setBookingListener(BookingListener bookingListener) {
        this.bookingListener = bookingListener;
    }

    public void setUpdateProductsListener(UpdateProductsListener updateProductsListener) {
        this.updateProductsListener = updateProductsListener;
    }

    public RequestQueue getVolleyQueue(){
        return volleyQueue;
    }

    /*
    private void generateDinamicBestSellingProducts() {
        bestSellingProducts = new ArrayList<>();
        bestSellingProducts.add(new BestSellingProduct(1,"Capa Iphone",20, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(2,"Cabo USB-C",10, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(3,"Película de Ecrã Iphone 13",12, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(4,"Película de Ecrã Xiaomi Redmi Note 13",12, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(5,"Mochila ASUS para Laptop ",55, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(6,"Rato Ergonómico Logitech",85, R.drawable.iphone_capa));
    }


    public ArrayList<BestSellingProduct> getbestSellingProductsExamples() {
        return new ArrayList<>(bestSellingProducts);
    }


    // region # PRODUCTS METHODS #

    private void generateDinamicProducts(){
        products = new ArrayList<>();
        products.add(new Product(1, "Capa Iphone",  10, R.drawable.iphone_capa));
        products.add(new Product(2, "Capa Samsung",  12, R.drawable.iphone_capa));
        products.add(new Product(3, "Película de Ecrã Iphone 13",  15, R.drawable.iphone_capa));
        products.add(new Product(4, "Película de Ecrã Xiaomi Redmi Note 13",  15, R.drawable.iphone_capa));
        products.add(new Product(5, "Mochila ASUS para Laptop",  55, R.drawable.iphone_capa));
        products.add(new Product(6, "Rato Ergonómico Logitech",  85, R.drawable.iphone_capa));
    }*/



    public ArrayList<Product> getProducts(){
        return new ArrayList<>(products);
    }

    public ArrayList<Product> getProductsDB(){
        products = dbHelper.getAllProductsDB();
        return new ArrayList<>(products);
    }

    public ArrayList<MyBooking> getMyBookingsDB(){
        myBookings = dbHelper.getAllBookingsDB();
        return new ArrayList<>(myBookings);
    }

    public void clearProductsDB(){
        dbHelper.removeProductsDB();
    }

    public Product getProduct(int id){
        for (Product product:products){
            if (product.getId() == id) {
                return product;
            }
        }
        return null;
    }

    public ArrayList<RepairCategoriesList> getAllRepairCategoriesListDB(){
        repairCategoriesList = dbHelper.getAllRepairCategoriesListDB();
        return new ArrayList<>(repairCategoriesList);
    }

    public ArrayList<RepairCategoryDetail> getAllRepairCategoriesDetailsListDB(){
        return new ArrayList<>(dbHelper.getAllRepairCategoriesDetailsListDB());
    }


    // endregion

    // region # Settings METHODS #

    public void setSettings(Settings settings){
        dbHelper.addSettingsDB(settings);
    }

    public Settings getSettings(){
        return dbHelper.getSettingsDB();
    }

    public void updateSettings(Settings settings){
        dbHelper.updateSettingsDB(settings);
    }

    // endregion

    // region # AUTH METHODS #

    public void setAuth(Auth auth){
        dbHelper.addAuthDB(auth);
    }

    public Auth getAuth(){
        return dbHelper.getAuthDB();
    }

    public void updateAuth(Auth auth){
        dbHelper.updateAuthDB(auth);
    }

    public void removeAuth(){
        dbHelper.removeAllAuthDB();
    }


    public Map<String, String> getHeaders() {
        Auth auth = dbHelper.getAuthDB();
        if (auth == null) {
            return Map.of("Dummy", "header");
        }
        return Map.of("Authorization", "Bearer " + auth.getToken());
    }

    public JSONObject getRefreshTokenBody() {
        Auth auth = dbHelper.getAuthDB();
        if (auth == null) {
            return null;
        }
        JSONObject body = new JSONObject();
        try {
            body.put("refresh_token", auth.getRefreshToken());
        } catch (Exception e) {
            e.printStackTrace();
        }
        return body;
    }

    public boolean isLogged() {
        return dbHelper.getAuthDB() != null;
    }

    public String getRole() {
        Auth auth = dbHelper.getAuthDB();
        if (auth == null) {
            return "";
        }
        return auth.getRole();
    }

    // endregion

    // region # AUTH API METHODS #

    public void login(String email, String password) {
        String url = "/api/auth/login";
        JSONObject body = new JSONObject();

        try {
            body.put("email", email);
            body.put("password", password);
        } catch (Exception e) {
            e.printStackTrace();
        }

        try {
            new ApiHelper(context).request(context, Request.Method.POST, url, body, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    if (response.optString("status").equals("success")) {
                        Auth auth = new Auth(
                                email,
                                response.optString("access_token"),
                                response.optString("refresh_token")
                        );
                        ReparaTechSingleton.getInstance(context).setAuth(auth);
                        Toast.makeText(context, context.getString(R.string.login_successful), Toast.LENGTH_SHORT).show();
                        if (loginListener != null) {
                            loginListener.onValidateLogin(true, ReparaTechSingleton.getInstance(context).getRole());
                        }
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(com.android.volley.VolleyError error) {
                    Toast.makeText(context, context.getString(R.string.login_failed), Toast.LENGTH_SHORT).show();
                    System.out.println(context.getString(R.string.login_failed));
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later), Toast.LENGTH_LONG).show();
        }
    }

    public void register(String email, String username, String name, String password) {
        String url = "/api/auth/register";
        JSONObject body = new JSONObject();

        try {
            body.put("email", email);
            body.put("username", username);
            body.put("name", name);
            body.put("password", password);
        } catch (Exception e) {
            e.printStackTrace();
        }

        try {
            new ApiHelper(context).request(context, Request.Method.POST, url, body, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    if (response.optString("status").equals("success")) {
                        if (registerListener != null) {
                            registerListener.onValidateRegister(true);
                        }
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(com.android.volley.VolleyError error) {
                    if (error.networkResponse != null) {
                        int statusCode = error.networkResponse.statusCode;
                        String errorMessage = new String(error.networkResponse.data);
                    }
                    Toast.makeText(context, context.getString(R.string.register_failed), Toast.LENGTH_SHORT).show();
                    System.out.println(context.getString(R.string.register_failed));
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later), Toast.LENGTH_LONG).show();
        }
    }

    public RepairCategoryDetail getRepairCategoryDetailById(int repairCategoryID) {
        for (RepairCategoryDetail repairCategoryDetail : getAllRepairCategoriesDetailsListDB()) {
            if (repairCategoryDetail.getIdCategory() == repairCategoryID) {
                return repairCategoryDetail;
            }
        }
        return null;
    }

    // endregion

    // region # PRODUCT METHODS #

    public void setProducts(ArrayList<Product> products){
        dbHelper.addProductsDB(products);
    }

    public void updateProducts(ArrayList<Product> products){
        dbHelper.removeProductsDB();
        dbHelper.addProductsDB(products);
    }

    // endregion

    // region # PRODUCT API METHODS #

    public void getProductsFromAPI(int page) {
        String url = "/api/products" + "?page=" + page;
        try {
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    products = ProductJsonParser.parserJsonProducts(response);
                    dbHelper.addProductsDB(products);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    products = dbHelper.getAllProductsDB();
                    Toast.makeText(context, context.getString(R.string.txt_error_loading_products_try_again_later), Toast.LENGTH_LONG).show();
                }
            });
        } catch (NoConnectionError e) {
            products = dbHelper.getAllProductsDB();
            Toast.makeText(context, context.getString(R.string.txt_no_internet_connection_try_again_later), Toast.LENGTH_LONG).show();
        }
    }

    public void addProductToCart(Product product, int quantity) {
        dbHelper.addProductToCartDB(product, quantity);
    }

    public void removeProductFromCart(Product product) {
        dbHelper.removeProductFromCartDB(product);
    }

    public void updateCartItem(int id, int quantity) {
        dbHelper.updateCartItemDB(id, quantity);
    }

    public void removeCartItem(int id) {
        dbHelper.removeCartItemDB(id);
    }

    // region # BOOKINGS API METHODS #

    public void bookingRequest(String date, String time){
        String url = "/api/booking/create";

        JSONObject body = new JSONObject();

        try{
            body.put("date", date); //os nomes têm de ser iguais aos que estão na base de dados
            body.put("time", time);

        }catch (Exception e){
            e.printStackTrace();
            System.out.println("Error creating booking request");
            return;
        }

        try{
            new ApiHelper(context).request(context, Request.Method.POST, url, body, new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            if (response.optString("status").equals("success")) {
                                if (bookingListener != null) {
                                    bookingListener.onValidateBooking(true);
                                }
                            }
                        }
                    }, new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(com.android.volley.VolleyError error) {
                            Toast.makeText(context, context.getString(R.string.txt_error_sending_repair_request), Toast.LENGTH_SHORT).show();
                            System.out.println(context.getString(R.string.txt_error_sending_repair_request));
                            error.printStackTrace();
                        }
                    });
        } catch (NoConnectionError e) {
                Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later), Toast.LENGTH_LONG).show();
        }
    }

    public void getBookingsFromApi (int page){
        String url = "/api/booking" + "?page=" + page;
        try{
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    myBookings = MyBookingJsonParser.parserJsonBookings(response);
                    dbHelper.addBookingsDB(myBookings);
                    if(bookingListener != null){
                        bookingListener.onValidateBooking(true);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(com.android.volley.VolleyError error) {
                    Toast.makeText(context,context.getString(R.string.txt_error_loading_bookings_try_again_later), Toast.LENGTH_SHORT).show();
                    System.out.println(context.getString(R.string.txt_error_loading_bookings_try_again_later));
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            myBookings = dbHelper.getAllBookingsDB();
            Toast.makeText(context, context.getString(R.string.txt_no_internet_connection_try_again_later), Toast.LENGTH_SHORT).show();
        }
    }
    public void updateBooking(MyBooking booking){

    }
    // endregion
}

