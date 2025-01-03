package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.NoConnectionError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Map;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.BookingListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.LoginListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.RegisterListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateProductsListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers.ProductJsonParser;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.utils.ApiHelper;

public class ReparaTechSingleton {
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private ArrayList<RepairCategoriesList> repairCategoriesList;
    private ArrayList<RepairCategoryDetail> repairCategoryDetails;
    private ArrayList<Product> products;
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
    public ArrayList<RepairExample> getRepairExamples(){
        ArrayList<RepairExample> repairExamples = new ArrayList<>();
        for (int i = 1; i <= 8; i++) {
            repairExamples.add(new RepairExample(
                repairCategories.get(i - 1).getId(),
                repairCategories.get(i - 1).getTitle(),
                repairCategories.get(i - 1).getImg()
            ));
        }
        repairExamples.add(new RepairExample(-1,"VIEW ALL",R.drawable.repairs));
        return repairExamples;
    }
    */


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
    */

    /*
    private void generateDinamicRepairCategories(){
        repairCategories = new ArrayList<>();
        repairCategories.add(new RepairCategoriesList(1,"Audio",
                "If your device does not transmit sounds, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.audio_issues));
        repairCategories.add(new RepairCategoriesList(2,"Battery",
                "If your device has battery damaged, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.battery_issues));
        repairCategories.add(new RepairCategoriesList(3,"Buttons",
                "If your device has some button damaged, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.buttons_iphone));
        repairCategories.add(new RepairCategoriesList(4,"Camera",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategoriesList(5,"Connectivity",
                "If your device has connectivity issues, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategoriesList(6,"Data Recovery",
                "Have you lost important data that you'd like to recover? Our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategoriesList(7,"Hardware",
                "Do you want to carry out routine maintenance? Our team is ready to do it with maximum efficiency.",
                R.drawable.cleaning_computer));
        repairCategories.add(new RepairCategoriesList(8,"Liquid Damage",
                "Has your device fallen into the pool and won't switch on? Our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategoriesList(9,"Network",
                "If your device has network issues, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.network_issues));
        repairCategories.add(new RepairCategoriesList(10,"Screen",
                "If your device has a damaged screen, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.broked_screen));
        repairCategories.add(new RepairCategoriesList(12,"Software",
                "If your device has malicious software, our team is ready to solve the problem with the utmost efficiency.",
                R.drawable.software_issues));
        repairCategories.add(new RepairCategoriesList(13,"Storage",
                "If your device has storage issues, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.storage_issues));
        repairCategories.add(new RepairCategoriesList(14, "Repair not Defined", "If the anomaly is not listed, please contact us!",R.drawable.repairs));
    }
    */

    /*
    public ArrayList<BestSellingProduct> getbestSellingProductsExamples() {
        return new ArrayList<>(bestSellingProducts);
    }
    */

    /*
    public RepairCategoriesList getRepairCategory(int id){
        for (RepairCategoriesList l:repairCategories){
            if (l.getId() == id) {
                return l;
            }
        }
        return null;
    }
    */


    // region # PRODUCTS METHODS #

    /*private void generateDinamicProducts(){
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
                            loginListener.onValidateLogin(true);
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

    public void bookingRequest(String bookingDate, String bookingHour){
        String url = "/api/booking/create";

        JSONObject body = new JSONObject();

        try{
            body.put("bookingDate", bookingDate);
            body.put("bookingHour", bookingHour);
        }catch (Exception e){
            e.printStackTrace();
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
    // endregion
}

