package pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class ProductJsonParser {
    public static Product parserJsonProduct(JSONObject response) {
        try {
            int id = response.getInt("id");
            int stock = response.getInt("stock");
            String name = response.getString("name");
            double price = response.getDouble("price");
            String image = response.getString("image");

            return new Product(id, name, price, image, stock);
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

    public static ArrayList<BestSellingProduct> parserJsonBestSellingProducts(JSONObject response) {
        try {
            ArrayList<BestSellingProduct> bestSellingProducts = new ArrayList<>();
            JSONArray jsonArray = response.getJSONArray("sales");
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject bestSellingProduct = jsonArray.getJSONObject(i);
                int id = bestSellingProduct.getInt("id");
                String name = bestSellingProduct.getString("name");
                double price = Double.parseDouble(bestSellingProduct.getString("price"));
                String image = bestSellingProduct.getString("image");

                bestSellingProducts.add(new BestSellingProduct(id, name, image, price));
            }
            return bestSellingProducts;
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

    public static ArrayList<Product> parseJsonProducts(JSONArray productsArray) {
        ArrayList<Product> products = new ArrayList<>();
        try {
            for (int i = 0; i < productsArray.length(); i++) {
                JSONObject productObject = productsArray.getJSONObject(i);
                Product product = new Product(
                        productObject.getInt("id"),
                        productObject.getString("name"),
                        productObject.getDouble("price"),
                        productObject.getString("image"),
                        productObject.getInt("stock")
                );
                products.add(product);
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return products;
    }
}
