package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.Context;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.utils.ApiHelper;

public class ReparaTechSingleton {
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private ArrayList<RepairCategory> repairCategories;
    private ArrayList<Product> products;
    private static ReparaTechSingleton instance;
    private Map<Integer, RepairCategoryDetail> repairCategoryDetails;
    private RepairCategoryDetail repairCategoryDetail;

    private static RequestQueue volleyQueue;
    private static ReparaTechSingleton INSTANCE = null;
    private Context context;
    private ReparaTechDBHelper dbHelper;

    private ReparaTechSingleton(Context context){
        products = new ArrayList<>();
        dbHelper = new ReparaTechDBHelper(context);
        this.context = context;
        generateDinamicRepairCategories();
        //generateDinamicBestSellingProducts();
        generateDinamicProducts();

    }

    public static synchronized ReparaTechSingleton getInstance(Context context){
        if(INSTANCE==null) {
            INSTANCE = new ReparaTechSingleton(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return INSTANCE;
    }

    public RequestQueue getVolleyQueue(){
        return volleyQueue;
    }

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


    private void generateDinamicRepairCategories(){
        repairCategories = new ArrayList<>();
        repairCategories.add(new RepairCategory(1,"Audio",
                "If your device does not transmit sounds, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.audio_issues));
        repairCategories.add(new RepairCategory(2,"Battery",
                "If your device has battery damaged, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.battery_issues));
        repairCategories.add(new RepairCategory(3,"Buttons",
                "If your device has some button damaged, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.buttons_iphone));
        repairCategories.add(new RepairCategory(4,"Camera",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(5,"Connectivity",
                "If your device has connectivity issues, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(6,"Data Recovery",
                "Have you lost important data that you'd like to recover? Our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(7,"Hardware",
                "Do you want to carry out routine maintenance? Our team is ready to do it with maximum efficiency.",
                R.drawable.cleaning_computer));
        repairCategories.add(new RepairCategory(8,"Liquid Damage",
                "Has your device fallen into the pool and won't switch on? Our team is ready to solve the problem with maximum efficiency.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(9,"Network",
                "If your device has network issues, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.network_issues));
        repairCategories.add(new RepairCategory(10,"Screen",
                "If your device has a damaged screen, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.broked_screen));
        repairCategories.add(new RepairCategory(12,"Software",
                "If your device has malicious software, our team is ready to solve the problem with the utmost efficiency.",
                R.drawable.software_issues));
        repairCategories.add(new RepairCategory(13,"Storage",
                "If your device has storage issues, our team is ready to solve the problem with maximum efficiency.",
                R.drawable.storage_issues));
        repairCategories.add(new RepairCategory(14, "Repair not Defined", "If the anomaly is not listed, please contact us!",R.drawable.repairs));
    }




    /*
    public ArrayList<BestSellingProduct> getbestSellingProductsExamples() {
        return new ArrayList<>(bestSellingProducts);
    }
    */




    public RepairCategory getRepairCategory(int id){
        for (RepairCategory l:repairCategories){
            if (l.getId() == id) {
                return l;
            }
        }
        return null;
    }

    // region # PRODUCTS METHODS #

    private void generateDinamicProducts(){
        products = new ArrayList<>();
        products.add(new Product(1, "Capa Iphone", "Capa para Iphone", 10, R.drawable.iphone_capa));
        products.add(new Product(2, "Capa Samsung", "Capa para Samsung", 12, R.drawable.iphone_capa));
        products.add(new Product(3, "Película de Ecrã Iphone 13", "Película de Ecrã para Iphone 13", 15, R.drawable.iphone_capa));
        products.add(new Product(4, "Película de Ecrã Xiaomi Redmi Note 13", "Película de Ecrã para Xiaomi Redmi Note 13", 15, R.drawable.iphone_capa));
        products.add(new Product(5, "Mochila ASUS para Laptop", "Mochila ASUS para Laptop", 55, R.drawable.iphone_capa));
        products.add(new Product(6, "Rato Ergonómico Logitech", "Rato Ergonómico Logitech", 85, R.drawable.iphone_capa));
    }

    public ArrayList<Product> getProducts(){
        return new ArrayList<>(products);
    }
    /*public ArrayList<Product> getProductsDB(){
        products = dbHelper.getAllProductsDB();
        return new ArrayList<>(products);

    }*/

    public Product getProduct(int id){
        for (Product product:products){
            if (product.getId() == id) {
                return product;
            }
        }
        return null;
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

        new ApiHelper(this.context).makeRequest(this.context, ApiHelper.JSON_OBJECT_REQUEST, Request.Method.POST, url, body, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                System.out.println("--------> POST API response:\n" + response.toString());

                // TODO: ADD LISTENER
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(com.android.volley.VolleyError error) {
                System.out.println("--------> POST API error:\n" + error.toString());
            }
        });
    }


    public ArrayList<RepairCategory> getRepairCategories() {
        return new ArrayList<>(repairCategories);
    }


}


    // endregion

    // region # AUTH API METHODS #

    // endregion


