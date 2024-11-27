package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.StrictMode;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;

import java.io.IOException;

import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.databinding.ActivityServerSettingsBinding;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Settings;

public class ServerSettingsActivity extends AppCompatActivity {

    private ActivityServerSettingsBinding binding;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityServerSettingsBinding.inflate(getLayoutInflater());

        SharedPreferences sharedPreferences = getSharedPreferences("settings", MODE_PRIVATE);
        Settings settings = new Settings(sharedPreferences);
        if (settings.getUrl() != null) {
            Intent intent = new Intent(this, LoginActivity.class);
            startActivity(intent);
            finish();
        }

        setContentView(binding.getRoot());

        binding.btnSave.setOnClickListener(view -> {
            String url = binding.txtServerUrl.getText().toString();
            if (url.isEmpty()) {
                Toast.makeText(this, R.string.url_cannot_be_empty_text, Toast.LENGTH_LONG).show();
                return;
            }
            settings.setUrl(url);
            Intent intent = new Intent(this, LoginActivity.class);
            startActivity(intent);
            finish();
        });
    }
}