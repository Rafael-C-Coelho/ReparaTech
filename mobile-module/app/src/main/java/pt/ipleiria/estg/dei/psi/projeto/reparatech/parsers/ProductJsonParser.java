package pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class ProductJsonParser {
    public static Product parserJsonProduct(JSONObject response) {
        try {
            int id = response.getInt("id");
            String name = response.getString("name");
            double price = response.getDouble("price");
            String image = response.getString("image");

            return new Product(id, name, price, image);
        } catch (JSONException e) {
            e.printStackTrace();
            return null;
        }
    }

    public static ArrayList<Product> parserJsonProducts(JSONObject response) {
        try {
            ArrayList<Product> products = new ArrayList<>();
            JSONArray jsonArray = response.getJSONArray("products");
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject product = jsonArray.getJSONObject(i);
                products.add(parserJsonProduct(product));
            }
            return products;
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }
}
