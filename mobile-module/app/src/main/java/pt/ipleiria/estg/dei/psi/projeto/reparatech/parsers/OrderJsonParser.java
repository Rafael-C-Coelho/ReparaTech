package pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class OrderJsonParser {

    public static Order parserJsonOrder(JSONObject response) {
        try {
            int id = response.getInt("id");
            String name = response.getString("name");
            double price = response.getDouble("price");

            List<Product> products = new ArrayList<>();
            return new Order(id, name, price, 0, products);
        } catch (JSONException e) {
            e.printStackTrace();
            return null;
        }
    }

    public static ArrayList<Order> parserJsonOrders(JSONObject response) {
        try {
            ArrayList<Order> orders = new ArrayList<>();
            JSONArray jsonArray = response.getJSONArray("orders");
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject product = jsonArray.getJSONObject(i);
                orders.add(parserJsonOrder(product));
            }
            return orders;
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }
}
