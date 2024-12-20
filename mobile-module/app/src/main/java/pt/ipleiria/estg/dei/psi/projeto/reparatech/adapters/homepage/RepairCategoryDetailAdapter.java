package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoryDetail;

public class RepairCategoryDetailAdapter extends ArrayAdapter<RepairCategoryDetail> {

    public RepairCategoryDetailAdapter(@NonNull Context context, ArrayList<RepairCategoryDetail> arrayRepairCategoryDetails) {
        super(context, R.layout.item_repair_category, arrayRepairCategoryDetails);
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View view, @NonNull ViewGroup parent) {

        RepairCategoryDetail repairCategoryDetail = getItem(position);


        if (view == null) {
            view = LayoutInflater.from(getContext()).inflate(R.layout.item_repair_category, parent, false);
        }

        /*
        ImageView imgRepairCategoryList = view.findViewById(R.id.imgRepairCategoryList);
        TextView tvRepairCategoryName = view.findViewById(R.id.tvRepairCategoryName);
        TextView tvCategoryDescription = view.findViewById(R.id.tvCategoryDescription);

        tvRepairCategoryName.setText(repairCategoryDetail.mobile);
        tvCategoryDescription.setText(repairCategoryDetail.tablet);
        */

        return view;
    }
}