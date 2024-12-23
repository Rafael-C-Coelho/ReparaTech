package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoryDetail;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class RepairCategoryDetailFragment extends Fragment {
    private static final String ID_CATEGORIES_LIST = "ID_CATEGORIES_LIST";
    private RepairCategoryDetail repairCategoryDetail;
    private Button btnRequestQuote;


    public RepairCategoryDetailFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_repair_category, container, false);


        TextView tvMobileDescription = view.findViewById(R.id.tvMobileDescription);
        TextView tvTabletDescription = view.findViewById(R.id.tvTabletDescription);
        TextView tvDesktopLaptopDescription = view.findViewById(R.id.tvDesktopLaptopDescription);
        TextView tvWearablesDescription = view.findViewById(R.id.tvWearablesDescription);
        int repairCategoryID = getArguments().getInt(ID_CATEGORIES_LIST);

        Bundle bundle = getArguments(); //receber o bundle
        if (bundle!=null){
          int idRepairCategories= bundle.getInt("ID_CATEGORIES_LIST");
          repairCategoryDetail = ReparaTechSingleton.getInstance(getContext()).getRepairCategoryDetail(idRepairCategories);
          updateUI(view);
        }
        return view;
    }

    private void updateUI(View view){
        TextView tvMobileDescription = view.findViewById(R.id.tvMobileDescription);
        TextView tvTabletDescription = view.findViewById(R.id.tvTabletDescription);
        TextView tvDesktopLaptopDescription = view.findViewById(R.id.tvDesktopLaptopDescription);
        TextView tvWearablesDescription = view.findViewById(R.id.tvWearablesDescription);

        if(repairCategoryDetail != null){
            tvMobileDescription.setText(repairCategoryDetail.getMobile_solution());
            tvTabletDescription.setText(repairCategoryDetail.getTablet_solution());
            tvDesktopLaptopDescription.setText(repairCategoryDetail.getDesktop_laptop_solution());
            tvWearablesDescription.setText(repairCategoryDetail.getWearable_solution());
        }

    }

}