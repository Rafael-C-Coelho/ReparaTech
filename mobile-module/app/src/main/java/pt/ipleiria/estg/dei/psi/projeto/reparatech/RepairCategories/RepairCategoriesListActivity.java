package pt.ipleiria.estg.dei.psi.projeto.reparatech.RepairCategories;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SearchView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.RepairCategoryDetailAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.databinding.ActivityMenuMainBinding;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoryDetail;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.RepairCategoriesListAdapter;
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

        repairCategories = ReparaTechSingleton.getInstance(getBaseContext()).getRepairCategories();


        lvRepairCategories.setAdapter(new RepairCategoriesListAdapter(RepairCategoriesListActivity.this,repairCategories));

        lvRepairCategories.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                Intent intent = new Intent(RepairCategoriesListActivity.this, RepairCategoriesDetailsActivity.class);
                intent.putExtra(RepairCategoriesDetailsActivity.ID_REPAIRCATEGORY, repairCategories.get(position).getId());
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


    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.search_menu, menu);
        MenuItem menuItem = menu.findItem(R.id.search_item);
        SearchView searchView = (SearchView) menuItem.getActionView();
        searchView.setQueryHint("Search Repair");

        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String s) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String s) {
                ArrayList<RepairCategory> repairCategoryArrayList= new ArrayList<>();

                for (RepairCategory repairCategory: ReparaTechSingleton.getInstance(getBaseContext()).getRepairCategories()) {
                    if (repairCategory.getTitle().toLowerCase().contains(s.toLowerCase())){
                        repairCategoryArrayList.add(repairCategory);
                    }
                }

                lvRepairCategories.setAdapter(new RepairCategoriesListAdapter(RepairCategoriesListActivity.this, repairCategoryArrayList));
                return true;
            }
        });
        return true;
    }
}