package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.CommentsAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateRepairsListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairEmployee;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class RepairEmployeeDetailsActivity extends AppCompatActivity implements UpdateRepairsListener {

    public static final String ID_REPAIR = "id_repair";
    private RepairEmployee repair;
    private TextView tvClientName, tvProgress, tvDevice;
    private EditText etHoursWorked;
    private Button btnSetDone;
    private ListView lvComments;
    private CommentsAdapter commentsAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repair_employee_details);
        ReparaTechSingleton.getInstance(this).setUpdateRepairsListener(this);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);
        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            actionBar.setDisplayHomeAsUpEnabled(true);
            actionBar.setHomeButtonEnabled(true);
            actionBar.setHomeAsUpIndicator(R.drawable.ic_back);
        }
        tvClientName = findViewById(R.id.tvClientName);
        tvProgress = findViewById(R.id.tvProgress);
        tvDevice = findViewById(R.id.tvDevice);
        btnSetDone = findViewById(R.id.btnSetDone);
        lvComments = findViewById(R.id.lvComments);
        ReparaTechSingleton.getInstance(this).setUpdateRepairsListener(this);

        btnSetDone.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ReparaTechSingleton.getInstance(getApplicationContext()).setRepairAsCompleted(repair.getId());
            }
        });

        int idRepair = getIntent().getIntExtra(ID_REPAIR, 0);
        if (idRepair != 0) {
            repair = ReparaTechSingleton.getInstance(getApplicationContext()).getRepairEmployeeByID(idRepair);
            if (repair != null) {
                updateUI();
            }
        }
    }

    private void updateUI() {
        repair = ReparaTechSingleton.getInstance(this).getRepairEmployeeByID(repair.getId());
        tvClientName.setText(repair.getClientName());
        tvProgress.setText(repair.getProgress());
        tvDevice.setText(repair.getDevice() + " - " + repair.getDescription());

        // Setup comments adapter
        commentsAdapter = new CommentsAdapter(this, ReparaTechSingleton.getInstance(this).getCommentsByRepair(repair.getId()));
        lvComments.setAdapter(commentsAdapter);

        // Update button visibility based on repair status
        if ("In Progress".equals(repair.getProgress())) {
            btnSetDone.setVisibility(View.VISIBLE);
        } else {
            btnSetDone.setVisibility(View.GONE);
        }
    }

    @Override
    public void onUpdateRepairs() {
        updateUI();
    }
}