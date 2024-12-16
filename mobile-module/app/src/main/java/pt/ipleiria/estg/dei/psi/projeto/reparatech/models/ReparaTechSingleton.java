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
                "If your device does not transmit sounds, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(2,"Battery",
                "If your device has battery damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(3,"Buttons",
                "If your device has some button damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(4,"Screen",
                "If your device has a damaged screen, our team is ready to solve the problem with maximum efficiency and quality.\".",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(5,"Camera",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(6,"Connectivity",
                "If your device has connectivity issues, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(7,"Data Recovery",
                "Have you lost important data that you'd like to recover? Our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(8,"Hardware",
                "Do you want to carry out routine maintenance or clean the internal components of your device? Our team is ready to do it with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(9,"Liquid Damage",
                "Has your device fallen into the pool and won't switch on? Our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(10,"Network",
                "If your device has network issues, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(11,"Software",
                "If your device has malicious software, our team is ready to solve the problem with the utmost efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(12,"Storage",
                "If your device has storage issues, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
    }


    private void generateDinamicProducts(){
        products = new ArrayList<>();
        products.add(new Product(1, "Capa Iphone", "Capa para Iphone", 10, R.drawable.iphone_capa));
        products.add(new Product(2, "Capa Samsung", "Capa para Samsung", 10, R.drawable.iphone_capa));
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

    public ArrayList<Product> getProducts(){
        return new ArrayList<>(products);
    }

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



    public RepairCategoryDetail getRepairCategoryDetail(int id) {
        return repairCategoryDetails.get(id);
    }


    public Map<Integer, RepairCategoryDetail> getRepairCategoryDetails() {
        repairCategoryDetails = new HashMap<>();
        repairCategoryDetails.put(1, new RepairCategoryDetail(1, "Mobile Info 1", "Tablet Info 1", "Desktop Info 1", "Wearable Info 1", "Cost Info 1", "Duration Info 1"));
        repairCategoryDetails.put(2, new RepairCategoryDetail(2, "Mobile Info 2", "Tablet Info 2", "Desktop Info 2", "Wearable Info 2", "Cost Info 2", "Duration Info 2"));
        repairCategoryDetails.put(3, new RepairCategoryDetail(3, "Mobile Info 3", "Tablet Info 3", "Desktop Info 3", "Wearable Info 3", "Cost Info 3", "Duration Info 3"));
        repairCategoryDetails.put(4, new RepairCategoryDetail(4, "Mobile Info 4", "Tablet Info 4", "Desktop Info 4", "Wearable Info 4", "Cost Info 4", "Duration Info 4"));
        repairCategoryDetails.put(5, new RepairCategoryDetail(5, "Mobile Info 5", "Tablet Info 5", "Desktop Info 5", "Wearable Info 5", "Cost Info 5", "Duration Info 5"));
        repairCategoryDetails.put(6, new RepairCategoryDetail(6, "Mobile Info 6", "Tablet Info 6", "Desktop Info 6", "Wearable Info 6", "Cost Info 6", "Duration Info 6"));

        return repairCategoryDetails;
    }

    public ArrayList<RepairCategory> getRepairCategories() {
        return new ArrayList<>(repairCategories);
    }


}


    // endregion

    // region # AUTH API METHODS #

    // endregion


