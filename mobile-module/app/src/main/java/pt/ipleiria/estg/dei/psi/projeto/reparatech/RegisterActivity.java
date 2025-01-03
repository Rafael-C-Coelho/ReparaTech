package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.databinding.ActivityRegisterBinding;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class RegisterActivity extends AppCompatActivity {

    private ActivityRegisterBinding binding;
    private EditText etName, etUsername, etEmail, etPassword;
    private Button btnSubmit;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityRegisterBinding.inflate(getLayoutInflater());
        setContentView(R.layout.activity_register);
        getWindow().getDecorView().setBackgroundColor(ContextCompat.getColor(RegisterActivity.this, R.color.gray));
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            actionBar.setDisplayHomeAsUpEnabled(true);
            actionBar.setHomeButtonEnabled(true);
            actionBar.setHomeAsUpIndicator(R.drawable.ic_back);
        }

        etName = findViewById(R.id.etName);
        etUsername = findViewById(R.id.etUsername);
        etEmail = findViewById(R.id.etEmail);
        etPassword = findViewById(R.id.etPassword);
        btnSubmit = findViewById(R.id.btnSubmit);


        btnSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String email = etEmail.getText().toString();
                String username = etUsername.getText().toString();
                String name = etName.getText().toString();
                String password = etPassword.getText().toString();

                ReparaTechSingleton.getInstance(RegisterActivity.this).register(email, username, name, password);
            }
        });
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == android.R.id.home) {
            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

}