package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.ProductsOrderAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateOrdersListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.SaleProduct;

public class OrderDetailsActivity extends AppCompatActivity implements UpdateOrdersListener {
    private TextView orderIdText, statusText, createdAtText, addressText, zipCodeText;
    private ListView productsListView;
    private ProductsOrderAdapter productsAdapter;
    private ArrayList<SaleProduct> saleProducts;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_details);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            actionBar.setDisplayHomeAsUpEnabled(true);
            actionBar.setHomeButtonEnabled(true);
            actionBar.setHomeAsUpIndicator(R.drawable.ic_back);
        }
        ReparaTechSingleton.getInstance(this).setUpdateOrdersListener(this);

        // Initialize views
        orderIdText = findViewById(R.id.orderIdText);
        statusText = findViewById(R.id.statusText);
        createdAtText = findViewById(R.id.createdAtText);
        addressText = findViewById(R.id.addressText);
        zipCodeText = findViewById(R.id.zipCodeText);
        productsListView = findViewById(R.id.productsListView);
        saleProducts = new ArrayList<>();

        int orderId = getIntent().getIntExtra("order_id", -1);
        if (orderId != -1) {
            loadOrderDetails(orderId);
        }
    }

    private void loadOrderDetails(int orderId) {
        Order order = ReparaTechSingleton.getInstance(this).getOrderById(orderId);
        if (order != null) {
            orderIdText.setText("Order ID: " + String.valueOf(order.getId()));
            statusText.setText("Status: " + order.getStatus());
            createdAtText.setText("Created at: " + order.getCreatedAt());
            addressText.setText("Address: " + order.getAddress());
            zipCodeText.setText("Zip code: " + order.getZipCode());
            saleProducts.clear();

            productsAdapter = new ProductsOrderAdapter(this, saleProducts);
            productsListView.setAdapter(productsAdapter);

            saleProducts.addAll(order.getSaleProducts());
            productsAdapter.notifyDataSetChanged();
        }
    }

    @Override
    public boolean onSupportNavigateUp() {
        onBackPressed();
        return true;
    }

    @Override
    public void reloadListOrders(boolean success) {
        if (success) {
            loadOrderDetails(getIntent().getIntExtra("order_id", -1));
        }
    }
}
