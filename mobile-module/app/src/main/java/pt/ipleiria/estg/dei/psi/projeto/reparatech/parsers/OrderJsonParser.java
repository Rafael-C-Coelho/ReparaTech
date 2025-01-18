package pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.SaleProduct;

public class OrderJsonParser {

    public static Order parserJsonOrder(JSONObject response) {
        try {
            int id = response.getInt("id");
            int clientId = response.getInt("client_id");
            String createdAt = response.getString("created_at");
            String status = response.getString("status");
            String address = response.getString("address");
            String zipCode = response.getString("zip_code");
            String invoice = response.getString("invoice");

            // Parse sale_products array
            ArrayList<SaleProduct> saleProducts = new ArrayList<>();
            JSONArray saleProductsArray = response.getJSONArray("sale_products");
            for (int i = 0; i < saleProductsArray.length(); i++) {
                JSONObject saleProductJson = saleProductsArray.getJSONObject(i);
                SaleProduct saleProduct = parseSaleProduct(saleProductJson);
                if (saleProduct != null) {
                    saleProducts.add(saleProduct);
                }
            }

            return new Order(id, clientId, createdAt, status, address, zipCode, invoice, saleProducts);
        } catch (JSONException e) {
            e.printStackTrace();
            return null;
        }
    }

    private static SaleProduct parseSaleProduct(JSONObject saleProductJson) {
        try {
            int id = saleProductJson.getInt("id");
            int saleId = saleProductJson.getInt("sale_id");
            int quantity = saleProductJson.getInt("quantity");
            double totalPrice = saleProductJson.getDouble("total_price");

            // Parse the nested product object
            JSONObject productJson = saleProductJson.getJSONObject("product");
            Product product = parseProduct(productJson);

            return new SaleProduct(id, saleId, quantity, totalPrice, product);
        } catch (JSONException e) {
            e.printStackTrace();
            return null;
        }
    }

    private static Product parseProduct(JSONObject productJson) {
        try {
            int id = productJson.getInt("id");
            String name = productJson.getString("name");
            double price = Double.parseDouble(productJson.getString("price")); // Price comes as string in the API
            String image = productJson.getString("image");
            int stock = productJson.getInt("stock");

            return new Product(id, name, price, image, stock);
        } catch (JSONException e) {
            e.printStackTrace();
            return null;
        }
    }

    public static ArrayList<Order> parserJsonOrders(JSONObject response) {
        try {
            ArrayList<Order> orders = new ArrayList<>();

            // Check if the response contains the "status" field and if it's "success"
            if (!response.has("status") || !response.getString("status").equals("success")) {
                return null;
            }

            JSONArray jsonArray = response.getJSONArray("sales");
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject orderJson = jsonArray.getJSONObject(i);
                Order order = parserJsonOrder(orderJson);
                if (order != null) {
                    orders.add(order);
                }
            }
            return orders;
        } catch (JSONException e) {
            e.printStackTrace();
            return null;
        }
    }
}