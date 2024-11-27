package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.databinding.ActivityRegisterBinding;

public class RegisterActivity extends AppCompatActivity {

    private ActivityRegisterBinding binding;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityRegisterBinding.inflate(getLayoutInflater());
        setContentView(R.layout.activity_register);
        getWindow().getDecorView().setBackgroundColor(ContextCompat.getColor(RegisterActivity.this, R.color.gray));
    }
}