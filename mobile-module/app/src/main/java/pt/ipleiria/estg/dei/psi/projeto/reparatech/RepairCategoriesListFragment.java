package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.widget.ViewUtils;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters_homepage.RepairCategoriesListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategory;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Singleton;

public class RepairCategoriesListFragment extends Fragment {

    private ListView lvRepairCategories;
    private ArrayList<RepairCategory> repairCategories;

    public RepairCategoriesListFragment() {
        repairCategories = new ArrayList<RepairCategory>();
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_repair_categories_list,container,false);

        lvRepairCategories = view.findViewById(R.id.lvRepairCategories);

        repairCategories = ReparaTechSingleton.getInstance().getRepairCategories();

        lvRepairCategories.setAdapter(new RepairCategoriesListAdapter(getContext(),repairCategories));

        lvRepairCategories.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {

                Intent intent = new Intent(getContext(), MenuMainActivity.class);
                startActivity(intent);
            }
        });

        return view;
    }
}