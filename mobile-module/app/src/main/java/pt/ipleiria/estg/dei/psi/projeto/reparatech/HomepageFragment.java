package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;


import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.HorizontalScrollView;
import android.widget.LinearLayout;
import android.widget.ListView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.BestSellingProductAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.HomePageRepairCategoryAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.HomePageRepairCategory;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoriesList;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class HomepageFragment extends Fragment {

    private ArrayList<HomePageRepairCategory> homePageRepairCategories;
    private ArrayList<RepairCategoriesList> repairCategoriesLists;
    private GridView gvHomePageRepairCategories;
    private HomePageRepairCategoryAdapter adapter;

    /*
    private HorizontalScrollView hScrollBestSellingProducts;
    private LinearLayout llBestSellingProducts;
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private BestSellingProductAdapter adapter;
    */


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_homepage, container, false);

        gvHomePageRepairCategories = view.findViewById(R.id.gvReparacoes);

        repairCategoriesLists = ReparaTechSingleton.getInstance(getContext()).getAllRepairCategoriesListDB();
        homePageRepairCategories = new ArrayList<>();

        for (RepairCategoriesList repairCategory : repairCategoriesLists) {
            homePageRepairCategories.add(new HomePageRepairCategory(
                    repairCategory.getId(),
                    repairCategory.getTitle(),
                    repairCategory.getImg()
            ));
        }

        adapter = new HomePageRepairCategoryAdapter(getActivity(), homePageRepairCategories);
        gvHomePageRepairCategories.setAdapter(adapter);

        gvHomePageRepairCategories.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                HomePageRepairCategory selectedCategory = homePageRepairCategories.get(position);
                Intent intent = new Intent(getActivity(), RepairCategoriesListActivity.class);
                startActivity(intent);
            }
        });

        return view;
    }

}

        /*
        hScrollBestSellingProducts = view.findViewById(R.id.hScrollBestSellingProducts);
        llBestSellingProducts = view.findViewById(R.id.BestSellingProducts);


        bestSellingProducts = ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsBD();
        if (bestSellingProducts.isEmpty()) {
            ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsFromApi(page);
            bestSellingProducts = ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsBD();
        }
        adapter = new BestSellingProductAdapter(getContext(), bestSellingProducts);
         */