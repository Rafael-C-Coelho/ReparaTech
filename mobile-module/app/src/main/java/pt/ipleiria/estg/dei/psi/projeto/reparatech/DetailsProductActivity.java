package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Context;
import android.os.Bundle;
import android.util.Log;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class DetailsProductActivity extends AppCompatActivity {

    public static final String ID_PRODUCT = "id_Product";
    private Product product;

    private TextView tvName, tvDescription, tvPrice;
    private ImageView imgProduct;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details_product);

        tvName = findViewById(R.id.tvNameProductDetails);
        imgProduct = findViewById(R.id.imgProductDetails);
        tvDescription = findViewById(R.id.tvDescriptionProductDetails);
        tvPrice = findViewById(R.id.tvPriceProductDetails);

        int productid = getIntent().getIntExtra(ID_PRODUCT, -1);
        if(productid != -1){
            product = ReparaTechSingleton.getInstance(this).getProduct(productid);
        }

        if (product != null) {
            carregarProduct();
        }
    }

    private void carregarProduct(){

        setTitle("Detalhes: "+product.getName());
        tvName.setText(product.getName());
        imgProduct.setImageResource(product.getImage());
        tvDescription.setText(product.getDescription());
        tvPrice.setText(""+product.getPrice());
    }
}