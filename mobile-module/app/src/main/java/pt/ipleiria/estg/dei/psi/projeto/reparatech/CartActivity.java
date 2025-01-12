package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.CartAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.CartItemChangeListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.CartItem;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class CartActivity extends AppCompatActivity implements CartItemChangeListener {

    private Button btnCheckout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cart);
        btnCheckout = findViewById(R.id.btnCompleteCheckout);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            actionBar.setDisplayHomeAsUpEnabled(true);
            actionBar.setHomeButtonEnabled(true);
            actionBar.setHomeAsUpIndicator(R.drawable.ic_back);
        }

        ListView listView = findViewById(R.id.lvCart);
        double total = 0;
        ArrayList<CartItem> allCartItemsDB = ReparaTechSingleton.getInstance(this).getDbHelper().getAllCartItemsDB();
        CartAdapter cartAdapter = new CartAdapter(this, allCartItemsDB, this);
        for (CartItem cartItem : allCartItemsDB) {
            Product product = ReparaTechSingleton.getInstance(this).getDbHelper().getAllProductsDB().get(cartItem.getIdProduct());
            total +=  product.getPrice() * cartItem.getQuantity();
        }
        listView.setAdapter(cartAdapter);
        TextView tvTotal = findViewById(R.id.tvTotal);
        tvTotal.setText(total + getString(R.string.euro_symbol));

        if (allCartItemsDB.isEmpty()) {
            btnCheckout.setEnabled(false);
        }

        btnCheckout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(CartActivity.this, FinishCartActivity.class);
                startActivity(intent);
            }
        });
    }

    @Override
    public void onCartItemChanged() {
        ListView listView = findViewById(R.id.lvCart);
        double total = 0;
        ArrayList<CartItem> allCartItemsDB = ReparaTechSingleton.getInstance(this).getDbHelper().getAllCartItemsDB();
        for (CartItem cartItem : allCartItemsDB) {
            Product product = ReparaTechSingleton.getInstance(this).getDbHelper().getAllProductsDB().get(cartItem.getIdProduct());
            total +=  product.getPrice() * cartItem.getQuantity();
        }
        TextView tvTotal = findViewById(R.id.tvTotal);
        tvTotal.setText(total + getString(R.string.euro_symbol));

        if (allCartItemsDB.isEmpty()) {
            btnCheckout.setEnabled(false);
        }
    }
}