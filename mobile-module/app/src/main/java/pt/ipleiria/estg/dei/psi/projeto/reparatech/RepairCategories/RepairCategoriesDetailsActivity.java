package pt.ipleiria.estg.dei.psi.projeto.reparatech.RepairCategories;

import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.ReparaTechSingleton.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategory;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoryDetail;

public class RepairCategoriesDetailsActivity extends AppCompatActivity {

    public static final String ID_REPAIRCATEGORY = "ID_REPAIRCATEGORY";
    private RepairCategory repairCategory;
    private ArrayList<RepairCategoryDetail> repairCategoryDetails;
    private Button btnRequestQuote;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_repair_categories_details);

        int id = getIntent().getIntExtra(ID_REPAIRCATEGORY, 0);

        repairCategory = ReparaTechSingleton.getInstance().getRepairCategory(id);

        TextView tvMobileRepairDescription = findViewById(R.id.tvMobileRepairDescription);
        TextView tvTabletSolutionRepairDescription = findViewById(R.id.tvTabletSolutionRepairDescription);
        TextView tvDesktopLaptopRepairDescription = findViewById(R.id.tvDesktopLaptopRepairDescription);
        TextView tvWearablesRepairDescription = findViewById(R.id.tvWearablesRepairDescription);
        TextView tvRepairTimeDescription = findViewById(R.id.tvRepairTimeDescription);
        TextView tvCostRepairDescription = findViewById(R.id.tvCostRepairDescription);
        ImageView imgMobileRepairButton = findViewById(R.id.imgMobileRepairButton);
        ImageView imgTabletRepairButton = findViewById(R.id.imgTabletRepairButton);
        ImageView imgDesktopLaptopRepairButton = findViewById(R.id.imgDesktopLaptopRepairButton);
        ImageView imgWearablesRepairButton = findViewById(R.id.imgWearablesRepairButton);
        ImageView imgRepairTimeButton = findViewById(R.id.imgRepairTimeButton);
        ImageView imgCostButton = findViewById(R.id.imgCostRepairButton);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        imgMobileRepairButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(tvMobileRepairDescription.getVisibility() == View.GONE){
                    tvMobileRepairDescription.setVisibility(View.VISIBLE);
                    imgMobileRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_up_);
                } else {
                    tvMobileRepairDescription.setVisibility(View.GONE);
                    imgMobileRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_down);
                }
            }
        });

        imgTabletRepairButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(tvTabletSolutionRepairDescription.getVisibility() == View.GONE){
                    tvTabletSolutionRepairDescription.setVisibility(View.VISIBLE);
                    imgTabletRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_up_);
                } else {
                   tvTabletSolutionRepairDescription.setVisibility(View.GONE);
                    imgTabletRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_down);
                }
            }
        });

        imgDesktopLaptopRepairButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(tvDesktopLaptopRepairDescription.getVisibility() == View.GONE){
                    tvDesktopLaptopRepairDescription.setVisibility(View.VISIBLE);
                    imgDesktopLaptopRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_up_);
                } else {
                    tvDesktopLaptopRepairDescription.setVisibility(View.GONE);
                    imgDesktopLaptopRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_down);
                }
            }
        });

        imgWearablesRepairButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(tvWearablesRepairDescription.getVisibility() == View.GONE){
                    tvWearablesRepairDescription.setVisibility(View.VISIBLE);
                    imgWearablesRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_up_);
                } else {
                    tvWearablesRepairDescription.setVisibility(View.GONE);
                    imgWearablesRepairButton.setImageResource(R.drawable.ic_keyboard_arrow_down);
                }
            }
        });

        imgRepairTimeButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(tvRepairTimeDescription.getVisibility() == View.GONE){
                    tvRepairTimeDescription.setVisibility(View.VISIBLE);
                    imgRepairTimeButton.setImageResource(R.drawable.ic_keyboard_arrow_up_);
                } else {
                    tvRepairTimeDescription.setVisibility(View.GONE);
                    imgRepairTimeButton.setImageResource(R.drawable.ic_keyboard_arrow_down);
                }
            }
        });

        imgCostButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(tvCostRepairDescription.getVisibility() == View.GONE){
                    tvCostRepairDescription.setVisibility(View.VISIBLE);
                    imgCostButton.setImageResource(R.drawable.ic_keyboard_arrow_up_);
                } else {
                    tvCostRepairDescription.setVisibility(View.GONE);
                    imgCostButton.setImageResource(R.drawable.ic_keyboard_arrow_down);
                }
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