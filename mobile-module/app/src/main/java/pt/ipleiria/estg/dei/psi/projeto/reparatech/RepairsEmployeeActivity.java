package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AbsListView;
import android.widget.AdapterView;
import android.widget.ListView;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.EmployeeRepairsAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateRepairsListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairEmployee;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class RepairsEmployeeActivity extends AppCompatActivity implements UpdateRepairsListener {

    private boolean isLoading = false, isEnd = false;
    private int page = 1;
    private ArrayList<RepairEmployee> repairs = new ArrayList<>();
    private EmployeeRepairsAdapter adapter;
    private SwipeRefreshLayout swipeRefreshLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repairs_employee);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            actionBar.setDisplayHomeAsUpEnabled(true);
            actionBar.setHomeButtonEnabled(true);
            actionBar.setHomeAsUpIndicator(R.drawable.ic_back);
        }
        ReparaTechSingleton.getInstance(this).setUpdateRepairsListener(this);
        adapter = new EmployeeRepairsAdapter(this, repairs);
        repairs.clear();
        repairs.addAll(ReparaTechSingleton.getInstance(this).getDbHelper().getAllRepairEmployeeDB());

        loadRepairs();

        swipeRefreshLayout = findViewById(R.id.swipeRefreshLayout);
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                refreshData();
            }
        });


        ListView lvRepairs = findViewById(R.id.lvRepairs);
        lvRepairs.setAdapter(adapter);
        lvRepairs.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent intent = new Intent(RepairsEmployeeActivity.this, RepairEmployeeDetailsActivity.class);
                intent.putExtra(RepairEmployeeDetailsActivity.ID_REPAIR, ReparaTechSingleton.getInstance(RepairsEmployeeActivity.this).getDbHelper().getAllRepairEmployeeDB().get(i).getId());
                startActivity(intent);
            }
        });

        lvRepairs.setOnScrollListener(new ListView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(AbsListView absListView, int i) {}

            @Override
            public void onScroll(AbsListView view, int firstVisibleItem, int visibleItemCount, int totalItemCount) {
                if (!isLoading && (firstVisibleItem + visibleItemCount >= totalItemCount) && totalItemCount > 0) {
                    if (isEnd) {
                        return;
                    }
                    loadRepairs();
                    lvRepairs.refreshDrawableState();
                    adapter.notifyDataSetChanged();
                }
            }
        });
    }

    private void loadRepairs() {
        if (isEnd) {
            return;
        }
        isLoading = true;
        int prevSize = ReparaTechSingleton.getInstance(this).getDbHelper().getAllRepairEmployeeDB().size();
        ReparaTechSingleton.getInstance(this).getRepairs(page);
        int currentSize = ReparaTechSingleton.getInstance(this).getDbHelper().getAllRepairEmployeeDB().size();
        if (prevSize == currentSize) {
            isLoading = false;
            isEnd = true;
        } else {
            page++;
        }
        isLoading = false;
    }

    private void refreshData() {
        // Reset pagination and flags
        page = 1;
        isEnd = false;
        isLoading = false;
        repairs.clear();

        // Clear database cache if needed
        ReparaTechSingleton.getInstance(this).getDbHelper().removeAllRepairEmployeeDB();

        // Load fresh data
        loadRepairs();
    }


    @Override
    public void onUpdateRepairs() {
        loadRepairs();
        if (swipeRefreshLayout.isRefreshing()) {
            swipeRefreshLayout.setRefreshing(false);
        }
        repairs.clear();
        repairs.addAll(ReparaTechSingleton.getInstance(this).getDbHelper().getAllRepairEmployeeDB());
        adapter.notifyDataSetChanged();
    }
}