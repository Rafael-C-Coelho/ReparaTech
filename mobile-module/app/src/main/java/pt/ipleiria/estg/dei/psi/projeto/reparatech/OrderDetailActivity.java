package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;
import android.widget.ListView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;

public class OrderDetailActivity extends AppCompatActivity {

    public static final String ID_ORDER = "id_order";
    private Order order;

    private TextView tvStatus, tvTotalOrder, tvProductQuantity;
    private ListView rvProducts;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_detail);
    }
}