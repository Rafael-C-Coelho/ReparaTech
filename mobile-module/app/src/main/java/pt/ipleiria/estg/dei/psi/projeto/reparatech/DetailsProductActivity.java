package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import static android.content.Intent.getIntent;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.ProductStockListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class DetailsProductActivity extends AppCompatActivity implements ProductStockListener {

    public static final String ID_PRODUCT = "id_Product";
    private Product product;

    private EditText etQuantity;
    private TextView tvName, tvPrice;
    private ImageView imgProduct;
    private Button btnBuyNow;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details_product);

        ReparaTechSingleton.getInstance(this).setProductStockListener(this);
        tvName = findViewById(R.id.tvNameProductDetails);
        imgProduct = findViewById(R.id.imgProductDetails);
        etQuantity = findViewById(R.id.etQuantity);
        tvPrice = findViewById(R.id.tvPriceProductDetails);
        btnBuyNow = findViewById(R.id.btnBuyProduct);
        btnBuyNow.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (!ReparaTechSingleton.getInstance(DetailsProductActivity.this).isLogged()) {
                    Toast.makeText(DetailsProductActivity.this, getString(R.string.you_need_to_be_logged_in_to_add_products_to_the_cart), Toast.LENGTH_SHORT).show();
                    Intent intent = new Intent(DetailsProductActivity.this, LoginActivity.class);
                    startActivity(intent);
                    return;
                }
                ReparaTechSingleton.getInstance(DetailsProductActivity.this).addProductToCart(product, Integer.parseInt(etQuantity.getText().toString()));
                Toast.makeText(DetailsProductActivity.this, "Product added to cart", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(DetailsProductActivity.this, MenuMainActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
            }
        });

        int productId = getIntent().getIntExtra(ID_PRODUCT, -1);
        if(productId != -1){
            product = ReparaTechSingleton.getInstance(this).getProduct(productId);
        }

        if (product != null) {
            carregarProduct();
        }
    }

    private void carregarProduct(){
        setTitle(getString(R.string.details_with_2_dots) + product.getName());
        tvName.setText(product.getName());
        Glide.with(getApplicationContext())
                .load(product.getImage())
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .into(imgProduct);
        tvPrice.setText(product.getPrice() + getString(R.string.euro_symbol));
    }

    @Override
    public void onProductStockChanged(int stock) {
        if (stock <= 0) {
            etQuantity.setText("0");
            etQuantity.setEnabled(false);
            btnBuyNow.setEnabled(false);
        } else {
            etQuantity.setEnabled(true);
            btnBuyNow.setEnabled(true);
        }
    }
}