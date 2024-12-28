package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.database.Cursor;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import org.w3c.dom.Text;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoryDetail;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechDBHelper;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class RepairCategoryDetailActivity extends AppCompatActivity {
    public static final String ID_CATEGORIES_LIST = "ID_CATEGORIES_LIST";
    private TextView tvMobileDescription, tvTabletDescription, tvDesktopLaptopDescription, tvWearablesDescription;
    private RepairCategoryDetail repairCategoryDetail;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repair_category_detail);
        getSupportActionBar().setHomeButtonEnabled(true);

        tvMobileDescription = findViewById(R.id.tvMobileDescription);
        tvTabletDescription = findViewById(R.id.tvTabletDescription);
        tvDesktopLaptopDescription = findViewById(R.id.tvDesktopLaptopDescription);
        tvWearablesDescription = findViewById(R.id.tvWearablesDescription);

        int idCategory = getIntent().getIntExtra(ID_CATEGORIES_LIST, 0);
        if (idCategory != 0) {
            repairCategoryDetail = ReparaTechSingleton.getInstance(getApplicationContext()).getRepairCategoryDetailById(idCategory);
            updateUI();
        }

    }

    private void updateUI() {
        if (repairCategoryDetail != null){
            tvMobileDescription.setText(repairCategoryDetail.getMobile_solution());
            tvTabletDescription.setText(repairCategoryDetail.getTablet_solution());
            tvDesktopLaptopDescription.setText(repairCategoryDetail.getDesktop_laptop_solution());
            tvWearablesDescription.setText(repairCategoryDetail.getWearable_solution());
        }
    }

    public boolean onOptionsItemSelected(MenuItem item){
        if(item.getItemId() == android.R.id.home){
            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}