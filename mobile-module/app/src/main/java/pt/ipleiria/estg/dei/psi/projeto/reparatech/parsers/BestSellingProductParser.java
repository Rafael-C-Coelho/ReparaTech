package pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBooking;

public class BestSellingProductParser {
    public static BestSellingProduct parserJsonBestSellingProduct(JSONObject response){
        try {
            int id = response.getInt("id");
            String name = response.getString("name");
            String image = response.getString("image");
            Double price = response.getDouble("price");
            return new BestSellingProduct(id,name,image,price);
        } catch (JSONException e){
            e.printStackTrace();
            return null;
        }
    }
    public static ArrayList<BestSellingProduct>  parserJsonBestSellingProducts(JSONObject response){
        try {
            ArrayList<BestSellingProduct> bestSellingProducts = new ArrayList<>();
            JSONArray jsonArray = response.getJSONArray("bestSellingProducts");
            for (int i = 0; i < jsonArray.length(); i++){
                JSONObject bestSellingProduct = jsonArray.getJSONObject(i);
               bestSellingProducts.add(parserJsonBestSellingProduct(bestSellingProduct));
            }
            return bestSellingProducts;
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }
}
