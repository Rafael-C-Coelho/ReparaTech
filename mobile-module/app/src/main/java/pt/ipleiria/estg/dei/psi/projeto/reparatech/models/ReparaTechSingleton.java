package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.NoConnectionError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.HomepageFragment;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.BestSellingProductClickListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.BestSellingProductListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.BookingListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.LoginListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.OrderListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.ProductStockListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.RegisterListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateBookingListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateOrdersListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateProductsListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateRepairsListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers.MyBookingJsonParser;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers.OrderJsonParser;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers.ProductJsonParser;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers.RepairEmployeeJsonParser;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.utils.ApiHelper;

public class ReparaTechSingleton {

    private ArrayList<RepairCategoriesList> repairCategoriesList;
    private ArrayList<Product> products;
    private ArrayList<MyBooking> myBookings;
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private ArrayList<Order> orders;
    private static RequestQueue volleyQueue;
    private static ReparaTechSingleton INSTANCE = null;
    private Context context;
    private ReparaTechDBHelper dbHelper;
    private Settings settings;

    private LoginListener loginListener;
    private RegisterListener registerListener;
    private BookingListener bookingListener;
    private UpdateBookingListener updateBookingListener;
    private UpdateProductsListener updateProductsListener;
    private ProductStockListener productStockListener;
    private UpdateRepairsListener updateRepairsListener;
    private BestSellingProductListener updateBestSellingProductsListener;
    private OrderListener orderListener;
    private UpdateOrdersListener updateOrdersListener;
    private BestSellingProductClickListener bestSellingProductClickListener;

    private ReparaTechSingleton(Context context) {
        products = new ArrayList<>();
        bestSellingProducts = new ArrayList<>();
        repairCategoriesList = new ArrayList<>();
        myBookings = new ArrayList<>();
        orders = new ArrayList<>();
        dbHelper = new ReparaTechDBHelper(context);
        settings = new Settings();

        this.context = context;
    }

    public static synchronized ReparaTechSingleton getInstance(Context context) {
        if (INSTANCE == null) {
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

    public void setBestSellingProductClickListener(BestSellingProductClickListener listener) {
        this.bestSellingProductClickListener = listener;
    }

    public BestSellingProductClickListener getBestSellingProductClickListener() {
        return bestSellingProductClickListener;
    }

    public void setUpdateRepairsListener(UpdateRepairsListener updateRepairsListener) {
        this.updateRepairsListener = updateRepairsListener;
    }

    public void setProductStockListener(ProductStockListener productStockListener) {
        this.productStockListener = productStockListener;
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

    public void setUpdateBookingListener(UpdateBookingListener updateBookingListener) {
        this.updateBookingListener = updateBookingListener;
    }

    public void setOrderListener(OrderListener orderListener) {
        this.orderListener = orderListener;
    }

    public void setUpdateOrdersListener(UpdateOrdersListener updateOrdersListener) {
        this.updateOrdersListener = updateOrdersListener;
    }

    public RequestQueue getVolleyQueue() {
        return volleyQueue;
    }

    // region # BEST SELLING PRODUCTS METHODS #

    // endregion

    // region # BEST SELLING PRODUCTS API METHODS #

    // endregion

    public ArrayList<RepairCategoriesList> getAllRepairCategoriesListDB() {
        repairCategoriesList = dbHelper.getAllRepairCategoriesListDB();
        return new ArrayList<>(repairCategoriesList);
    }

    public ArrayList<RepairCategoryDetail> getAllRepairCategoriesDetailsListDB() {
        return new ArrayList<>(dbHelper.getAllRepairCategoriesDetailsListDB());
    }

    // endregion

    // region # Settings METHODS #

    public void setSettings(Settings settings) {
        dbHelper.addSettingsDB(settings);
    }

    public Settings getSettings() {
        return dbHelper.getSettingsDB();
    }

    public void updateSettings(Settings settings) {
        dbHelper.updateSettingsDB(settings);
    }

    // endregion

    // region # AUTH METHODS #

    public void setAuth(Auth auth) {
        dbHelper.addAuthDB(auth);
    }

    public Auth getAuth() {
        return dbHelper.getAuthDB();
    }

    public void updateAuth(Auth auth) {
        dbHelper.updateAuthDB(auth);
    }

    public void removeAuth() {
        dbHelper.removeAllAuthDB();
    }

    public Map<String, String> getAuthHeaders() {
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
            new ApiHelper(context).request(context, Request.Method.POST, url, body,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            if (response.optString("status").equals("success")) {
                                Auth auth = new Auth(
                                        email,
                                        response.optString("access_token"),
                                        response.optString("refresh_token"));
                                ReparaTechSingleton.getInstance(context).setAuth(auth);
                                Toast.makeText(context, context.getString(R.string.login_successful),
                                        Toast.LENGTH_SHORT).show();
                                if (loginListener != null) {
                                    loginListener.onValidateLogin(true,
                                            ReparaTechSingleton.getInstance(context).getRole());
                                }
                            }
                        }
                    }, new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(com.android.volley.VolleyError error) {
                            Toast.makeText(context, context.getString(R.string.login_failed), Toast.LENGTH_SHORT)
                                    .show();
                            System.out.println(context.getString(R.string.login_failed));
                            error.printStackTrace();
                        }
                    });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later),
                    Toast.LENGTH_LONG).show();
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
            new ApiHelper(context).request(context, Request.Method.POST, url, body,
                    new Response.Listener<JSONObject>() {
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
                            Toast.makeText(context, context.getString(R.string.register_failed), Toast.LENGTH_SHORT)
                                    .show();
                            System.out.println(context.getString(R.string.register_failed));
                            error.printStackTrace();
                        }
                    });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later),
                    Toast.LENGTH_LONG).show();
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

    public ArrayList<Product> getProductsDB() {
        products = dbHelper.getAllProductsDB();
        return new ArrayList<Product>(products);
    }

    public void clearProductsDB() {
        dbHelper.removeProductsDB();
    }

    public Product getProductFromDB(int id) {
        for (Product product : getProductsDB()) {
            if (product.getId() == id) {
                return product;
            }
        }
        return null;
    }

    public void updateProductStockDB(int id, int stock) {
        dbHelper.updateProductStock(id, stock);
    }

    public Product getProduct(int id) {
        try {
            new ApiHelper(context).request(context, Request.Method.GET, "/api/products/" + id, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            try {
                                JSONObject productObject = response.getJSONObject("product");
                                Product product = new Product(
                                        productObject.getInt("id"),
                                        productObject.getString("name"),
                                        productObject.getDouble("price"),
                                        productObject.getString("image"),
                                        productObject.getInt("stock"));

                                if (productStockListener != null) {
                                    productStockListener.onProductStockChanged(productObject.getInt("id"), productObject.getInt("stock"));
                                }
                                dbHelper.addProductDB(product);
                            } catch (JSONException e) {
                                e.printStackTrace();
                                if (productStockListener != null) {
                                    productStockListener.onProductStockChanged(id, 0);
                                }
                            }
                        }
                    }, new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            error.printStackTrace();
                            if (productStockListener != null) {
                                productStockListener.onProductStockChanged(id, 0);
                            }
                        }
                    });
            for (Product product : products) {
                if (product.getId() == id) {
                    return product;
                }
                if (productStockListener != null) {
                    productStockListener.onProductStockChanged(id, 0);
                }
            }
            return null;
        } catch (Exception e) {
            e.printStackTrace();
            if (productStockListener != null) {
                productStockListener.onProductStockChanged(id, 0);
            }
        }
        return null;
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
                    int i = 0;
                    for (Product product : products) {
                        if (getProduct(product.getId()) != null) {
                            i++;
                        }
                    }
                    dbHelper.addProductsDB(products);
                    if (updateProductsListener != null) {
                        updateProductsListener.reloadListProducts(true, i);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    products = dbHelper.getAllProductsDB();
                    Toast.makeText(context, context.getString(R.string.txt_error_loading_products_try_again_later),
                            Toast.LENGTH_LONG).show();
                }
            });
        } catch (NoConnectionError e) {
            products = dbHelper.getAllProductsDB();
            Toast.makeText(context, context.getString(R.string.txt_no_internet_connection_try_again_later),
                    Toast.LENGTH_LONG).show();
        }
    }

    public void addProductToCart(Product product, int quantity) {
        if (quantity <= 0) {
            Toast.makeText(context, R.string.quantity_must_be_greater_than_0, Toast.LENGTH_SHORT).show();
            return;
        }
        dbHelper.addProductToCartDB(product, quantity);
    }

    public void removeCartItem(int id) {
        dbHelper.removeCartItemDB(id);
    }

    public void updateCartItem(int id, int quantity) {
        dbHelper.updateCartItemDB(id, quantity);
    }

    public void createOrder(String address, String zipCode) {
        String url = "/api/sales";
        JSONObject body = new JSONObject();
        try {
            body.put("address", address);
            body.put("zip_code", zipCode);
        } catch (Exception e) {
            e.printStackTrace();
        }

        JSONArray saleProducts = new JSONArray();
        for (CartItem cartItem : dbHelper.getAllCartItemsDB()) {
            JSONObject saleProduct = new JSONObject();
            try {
                saleProduct.put("product_id", cartItem.getIdProduct());
                saleProduct.put("quantity", cartItem.getQuantity());
                saleProducts.put(saleProduct);
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        try {
            body.put("cart", saleProducts);
        } catch (Exception e) {
            e.printStackTrace();
        }

        try {
            new ApiHelper(context).request(context, Request.Method.POST, url, body,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            if (response.optString("status").equals("success")) {
                                Toast.makeText(context, context.getString(R.string.your_order_has_been_created),
                                        Toast.LENGTH_SHORT).show();
                                ReparaTechSingleton.getInstance(context).getDbHelper().removeCartItemsDB();
                            } else {
                                Toast.makeText(context, context.getString(R.string.there_was_an_error_on_your_order),
                                        Toast.LENGTH_SHORT).show();
                                System.out.println(response);
                            }
                        }
                    }, new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(context, context.getString(R.string.there_was_an_error_on_your_order),
                                    Toast.LENGTH_SHORT).show();
                            error.printStackTrace();
                            ReparaTechSingleton.getInstance(context).getDbHelper().removeCartItemsDB();
                        }
                    });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later),
                    Toast.LENGTH_LONG).show();
        }
    }

    // endregion

    // region # PRODUCT METHODS #
    public ArrayList<MyBooking> getMyBookingsDB() {
        myBookings = dbHelper.getAllBookingsDB();
        return new ArrayList<>(myBookings);
    }

    public ArrayList<BestSellingProduct> getBestSellingProductsBD() {
        bestSellingProducts = dbHelper.getAllBestSellingProductsDB();
        return new ArrayList<>(bestSellingProducts);
    }

    public void clearBookingsDB() {
        dbHelper.removeBookingsDB();
    }
    // endregion

    // region # BOOKINGS API METHODS #

    public void bookingRequest(String date, String time) {
        String url = "/api/booking/create";

        JSONObject body = new JSONObject();

        try {
            body.put("date", date); // os nomes têm de ser iguais aos que estão na base de dados
            body.put("time", time);

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("Error creating booking request");
            return;
        }

        try {
            new ApiHelper(context).request(context, Request.Method.POST, url, body,
                    new Response.Listener<JSONObject>() {
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
                            Toast.makeText(context, context.getString(R.string.txt_error_sending_repair_request),
                                    Toast.LENGTH_SHORT).show();
                            System.out.println(context.getString(R.string.txt_error_sending_repair_request));
                            error.printStackTrace();
                        }
                    });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later),
                    Toast.LENGTH_LONG).show();
        }
    }

    public void getBookingsFromApi(int page) {
        String url = "/api/booking" + "?page=" + page;
        try {
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    myBookings = MyBookingJsonParser.parserJsonBookings(response);
                    dbHelper.addBookingsDB(myBookings);
                    if (bookingListener != null) {
                        bookingListener.onValidateBooking(true);
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(com.android.volley.VolleyError error) {
                    Toast.makeText(context, context.getString(R.string.txt_error_loading_bookings_try_again_later),
                            Toast.LENGTH_SHORT).show();
                    System.out.println(context.getString(R.string.txt_error_loading_bookings_try_again_later));
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            myBookings = dbHelper.getAllBookingsDB();
            Toast.makeText(context, context.getString(R.string.txt_no_internet_connection_try_again_later),
                    Toast.LENGTH_SHORT).show();
        }
    }

    public void updateBookings(MyBooking myBooking) {
        String url = "/api/booking/" + myBooking.getId();
        try {
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    try {
                        // Parse the updated status from the response
                        String updatedStatus = response.getString("status");
                        myBooking.setStatus(updatedStatus);

                        // Update the local database with the new status
                        dbHelper.updateBookingDB(myBooking.getId(), myBooking.getStatus());

                        if (updateBookingListener != null) {
                            updateBookingListener.updateBookings(myBooking);
                            System.out.println("Booking Updated");
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    if (updateBookingListener != null) {
                        updateBookingListener.updateBookings(myBooking);
                        System.out.println("Booking update failed");
                    }
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            dbHelper.updateBookingDB(myBooking.getId(), myBooking.getStatus());
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later),
                    Toast.LENGTH_LONG).show();
        }
    }

    // endregion

    // region # Repairs METHODS #

    public ArrayList<RepairEmployee> getRepairsDB() {
        return new ArrayList<>(dbHelper.getAllRepairEmployeeDB());
    }

    public void getRepairs(int page) {
        String url = "/api/repairs?page=" + page;
        try {
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    try {
                        JSONArray repairs = response.getJSONArray("repairs");
                        for (int i = 0; i < repairs.length(); i++) {
                            JSONObject repair = repairs.getJSONObject(i);
                            RepairEmployee repairEmployee = new RepairEmployee(
                                    repair.getInt("id"),
                                    repair.getString("device"),
                                    repair.getString("description"),
                                    repair.getString("progress"),
                                    repair.getString("client_name"));
                            dbHelper.addRepairEmployeeDB(repairEmployee);
                        }

                        if (updateRepairsListener != null) {
                            updateRepairsListener.onUpdateRepairs();
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    if (updateRepairsListener != null) {
                        updateRepairsListener.onUpdateRepairs();
                    }
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.txt_no_internet_connection_try_again_later),
                    Toast.LENGTH_SHORT).show();
        }
    }

    public RepairEmployee getRepairEmployeeByID(int id) {
        String url = "/api/repairs/" + id;
        try {
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    try {
                        response = response.getJSONObject("repair");
                        RepairEmployee repairEmployee = new RepairEmployee(
                                response.getInt("id"),
                                response.getString("device"),
                                response.getString("description"),
                                response.getString("progress"),
                                response.getString("client_name"));
                        dbHelper.addRepairEmployeeDB(repairEmployee);
                        dbHelper.addCommentsDB(
                                RepairEmployeeJsonParser.parseComments(response.getJSONArray("comments"))
                        );

                        if (updateRepairsListener != null) {
                            updateRepairsListener.onUpdateRepairs();
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    if (updateRepairsListener != null) {
                        updateRepairsListener.onUpdateRepairs();
                    }
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.no_internet_connection_try_again_later),
                    Toast.LENGTH_LONG).show();
        }
        for (RepairEmployee repairEmployee : dbHelper.getAllRepairEmployeeDB()) {
            if (repairEmployee.getId() == id) {
                return repairEmployee;
            }
        }
        return null;
    }

    public void setBestSellingProductsListener(BestSellingProductListener listener) {
        this.updateBestSellingProductsListener = listener;
    }

    public void clearRepairsDB() {
        dbHelper.removeAllRepairEmployeeDB();
    }

    public void setRepairAsCompleted(int repairId) {
        try {
            JSONObject requestBody = new JSONObject();
            requestBody.put("progress", "Completed");
            new ApiHelper(context).request(
                    context,
                    Request.Method.PATCH,
                    "/api/repairs/" + repairId + "/progress",
                    requestBody,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            if (response.optString("status").equals("success")) {
                                // Update local database
                                RepairEmployee repair = getRepairEmployeeByID(repairId);
                                if (repair != null) {
                                    repair.setProgress("Completed");
                                    dbHelper.updateRepairEmployeeDB(repairId, "Completed");
                                    if (updateRepairsListener != null) {
                                        updateRepairsListener.onUpdateRepairs();
                                    }
                                    Toast.makeText(context, context.getString(R.string.repair_set_as_done), Toast.LENGTH_SHORT).show();
                                }
                            }
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(context, R.string.error_setting_repair_as_done,
                                    Toast.LENGTH_SHORT).show();
                            Log.e("ReparaTechSingleton", "Error setting repair as done: " + error.toString());
                        }
                    }
            );
        } catch (JSONException e) {
            Log.e("ReparaTechSingleton", "Error creating request body: " + e.toString());
        } catch (NoConnectionError e) {
            Toast.makeText(context, R.string.no_internet_connection_try_again_later,
                    Toast.LENGTH_LONG).show();
            Log.e("ReparaTechSingleton", "No internet connection");
        }
    }

    public ArrayList<Comment> getCommentsByRepair(int id) {
        return new ArrayList<>(dbHelper.getCommentsByRepairDB(id));
    }

    // endregion

    // region # ORDER METHODS #

    public Order getOrder(int id) {
        try {
            new ApiHelper(context).request(context, Request.Method.GET, "/api/orders/" + id, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            try {
                                JSONObject orderObject = response.getJSONObject("order");
                                Order order = new Order(
                                        orderObject.getInt("id"),
                                        orderObject.getString("status"),
                                        orderObject.getDouble("total_order"),
                                        orderObject.getInt("product_quantity"),
                                        ProductJsonParser.parseJsonProducts(orderObject.getJSONArray("products")));
                                dbHelper.addOrder(new ArrayList<>(List.of(order)));
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                    }, new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            error.printStackTrace();
                        }
                    });
            for (Order order : orders) {
                if (order.getId() == id) {
                    return order;
                }
            }
            return null;
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    public void getOrders() {
        String url = "/api/sales";
        try {
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                        orders = OrderJsonParser.parserJsonOrders(response);
                        if(orders == null) {
                            orders = new ArrayList<>();
                        }
                        int i = 0;
                        for (Order order : orders) {
                            if (getOrder(order.getId()) != null) {
                                i++;
                            }
                        }
                        dbHelper.addOrder(orders);
                        if (updateOrdersListener != null) {
                            updateOrdersListener.reloadListOrders(true);
                        }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    if (updateRepairsListener != null) {
                        updateRepairsListener.onUpdateRepairs();
                    }
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            Toast.makeText(context, context.getString(R.string.txt_no_internet_connection_try_again_later),
                    Toast.LENGTH_SHORT).show();
        }
    }

    public ArrayList<Order> getOrdersDB() {
        orders = dbHelper.getAllOrdersDB();
        return new ArrayList<Order>(orders);
    }

    public void clearOrdersDB() {
        dbHelper.removeAllOrdersDB();
    }

    // endregion


/*
    public void getBestSellingProductsFromApi(int page) {
        String url = "/api/dashboard/most-sold" + "?page=" + page;
        try {
            new ApiHelper(context).request(context, Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                   bestSellingProducts = ProductJsonParser.parserJsonBestSellingProducts(response);
                    if (bestSellingProducts != null) {
                        dbHelper.removeBestSellingProductsDB();
                        dbHelper.addBestSellingProductsDB(bestSellingProducts); // Add new data
                        if (updateBestSellingProductsListener != null) {
                            updateBestSellingProductsListener.onProductsFetched(bestSellingProducts);
                        }
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, context.getString(R.string.txt_error_loading_bookings_try_again_later),
                            Toast.LENGTH_SHORT).show();
                    error.printStackTrace();
                }
            });
        } catch (NoConnectionError e) {
            bestSellingProducts = dbHelper.getAllBestSellingProductsDB();
            Toast.makeText(context, context.getString(R.string.txt_no_internet_connection_try_again_later),
                    Toast.LENGTH_SHORT).show();
        }
    }
}
