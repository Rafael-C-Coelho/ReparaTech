package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.databinding.ActivityServerSettingsBinding;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Settings;

public class ServerSettingsActivity extends AppCompatActivity {

    private ActivityServerSettingsBinding binding;
    private Settings settings;
    public static final String ACTION = "ACTION";
    public static final String EDIT_ACTION = "EDIT";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        this.settings = ReparaTechSingleton.getInstance(this).getSettings();
        binding = ActivityServerSettingsBinding.inflate(getLayoutInflater());

        if (getIntent().getStringExtra(ACTION) != null && getIntent().getStringExtra(ACTION).equals(EDIT_ACTION)) {
            binding.txtServerUrl.setText(this.settings.getUrl());
        } else {
            if (this.settings != null) {
                Intent intent = new Intent(this, MenuMainActivity.class);
                startActivity(intent);
                finish();
            }
        }

        setContentView(binding.getRoot());

        binding.btnSave.setOnClickListener(view -> {
            String url = binding.txtServerUrl.getText().toString();
            if (url.isEmpty()) {
                Toast.makeText(this, R.string.url_cannot_be_empty_text, Toast.LENGTH_LONG).show();
                return;
            }
            this.settings = new Settings(url);
            ReparaTechSingleton.getInstance(this).setSettings(this.settings);
            Intent intent = new Intent(this, MenuMainActivity.class);
            startActivity(intent);
            finish();
        });
    }
}