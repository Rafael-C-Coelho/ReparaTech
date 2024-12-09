package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.databinding.ActivityLoginBinding;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class LoginActivity extends AppCompatActivity {

    private ActivityLoginBinding binding;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityLoginBinding.inflate(getLayoutInflater());
        setContentView(R.layout.activity_login);
        getWindow().getDecorView().setBackgroundColor(ContextCompat.getColor(LoginActivity.this, R.color.gray));
        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null){
            actionBar.setDisplayHomeAsUpEnabled(true);
            actionBar.setHomeButtonEnabled(true);
            actionBar.setHomeAsUpIndicator(R.drawable.ic_back);
        }
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        binding.btnSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String email = binding.etEmail.getText().toString();
                String password = binding.etPassword.getText().toString();
                if (email.isEmpty() || password.isEmpty()) {
                    binding.etEmail.setError(getString(R.string.email_cannot_be_empty));
                    binding.etPassword.setError(getString(R.string.password_cannot_be_empty));
                    return;
                }
                ReparaTechSingleton.getInstance(LoginActivity.this).login(email, password);
                Intent intent = new Intent(LoginActivity.this, MenuMainActivity.class);
                startActivity(intent);
                finish();
            }
        });
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){
        if (item.getItemId() == android.R.id.home) {
            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}