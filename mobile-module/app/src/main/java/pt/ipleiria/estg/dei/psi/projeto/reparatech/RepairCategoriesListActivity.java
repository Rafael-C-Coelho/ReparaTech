package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoryDetail;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.RepairCategoriesListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoriesList;

public class RepairCategoriesListActivity extends AppCompatActivity {

    private ListView lvRepairCategories;
    private ArrayList<RepairCategoriesList> repairCategoriesList;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repair_categories_list);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        lvRepairCategories = findViewById(R.id.lvRepairCategories);

        repairCategoriesList = ReparaTechSingleton.getInstance(getBaseContext()).getAllRepairCategoriesListDB();


        lvRepairCategories.setAdapter(new RepairCategoriesListAdapter(RepairCategoriesListActivity.this,repairCategoriesList));

        lvRepairCategories.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                Intent intent = new Intent(RepairCategoriesListActivity.this, RepairCategoryDetailActivity.class);
                intent.putExtra(RepairCategoryDetailActivity.ID_CATEGORIES_LIST, repairCategoriesList.get(position).getId());
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

        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() { //filtro de pesquisa
            @Override
            public boolean onQueryTextSubmit(String s) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String s) {
                ArrayList<RepairCategoriesList> repairCategoryArrayList= new ArrayList<>();

                for (RepairCategoriesList repairCategory: ReparaTechSingleton.getInstance(getBaseContext()).getAllRepairCategoriesListDB()) {
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