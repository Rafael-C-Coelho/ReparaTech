package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class FinishCartActivity extends AppCompatActivity {

    private Button btnFinish;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_finish_cart);

        EditText etAddress = findViewById(R.id.etAddress);
        EditText etZipCode = findViewById(R.id.etZipCode);
        btnFinish = findViewById(R.id.btnFinalize);
        btnFinish.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                ReparaTechSingleton.getInstance(FinishCartActivity.this).createOrder(etAddress.getText().toString(), etZipCode.getText().toString());
                Intent intent = new Intent(FinishCartActivity.this, MenuMainActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
            }
        });
    }
}