package pt.ipleiria.estg.dei.psi.projeto.reparatech.RepairCategories;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.ReparaTechSingleton.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters_homepage.RepairCategoriesListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategory;

public class RepairCategoriesListActivity extends AppCompatActivity {

    private ListView lvRepairCategories;
    private ArrayList<RepairCategory> repairCategories;

    public RepairCategoriesListActivity() {

    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repair_categories_list);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);


        lvRepairCategories = findViewById(R.id.lvRepairCategories);

        repairCategories = ReparaTechSingleton.getInstance().getRepairCategories();


        lvRepairCategories.setAdapter(new RepairCategoriesListAdapter(RepairCategoriesListActivity.this,repairCategories));

        lvRepairCategories.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {

                Intent intent = new Intent(RepairCategoriesListActivity.this, RepairCategoriesDetailsActivity.class);
                intent.putExtra(RepairCategoriesDetailsActivity.ID_REPAIRCATEGORY,(int) l);
                startActivity(intent);

            }
        });

    }


    public boolean onOptionsItemSelected(MenuItem item){
        if(item.getItemId() == android.R.id.home){
            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}