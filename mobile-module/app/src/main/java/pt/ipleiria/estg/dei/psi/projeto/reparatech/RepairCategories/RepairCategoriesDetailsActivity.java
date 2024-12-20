package pt.ipleiria.estg.dei.psi.projeto.reparatech.RepairCategories;


import android.os.Bundle;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;

public class RepairCategoriesDetailsActivity extends AppCompatActivity {

    public static final String ID_REPAIRCATEGORY = "ID_REPAIRCATEGORY";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repair_categories_details);

        int repairCategoryId = getIntent().getIntExtra(ID_REPAIRCATEGORY, -1);
        //TextView tvTitle = findViewById(R.id.tvMobileRepairTitle);
    // tvTitle.setText("Repair Category ID: " + repairCategoryId);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
    }
}