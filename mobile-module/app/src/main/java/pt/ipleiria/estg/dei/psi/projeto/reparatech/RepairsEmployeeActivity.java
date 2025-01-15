package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.EmployeeRepairsAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class RepairsEmployeeActivity extends AppCompatActivity {

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

        ListView lvRepairs = findViewById(R.id.lvRepairs);
        lvRepairs.setAdapter(new EmployeeRepairsAdapter(this, ReparaTechSingleton.getInstance(this).getDbHelper().getAllRepairEmployeeDB()));
        lvRepairs.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                Intent intent = new Intent(RepairsEmployeeActivity.this, RepairEmployeeDetailsActivity.class);
                intent.putExtra(RepairEmployeeDetailsActivity.ID_REPAIR, ReparaTechSingleton.getInstance(RepairsEmployeeActivity.this).getDbHelper().getAllRepairEmployeeDB().get(i).getId());
                startActivity(intent);
            }
        });
    }
}