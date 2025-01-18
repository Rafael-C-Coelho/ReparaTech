package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.graphics.Rect;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

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
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.BestSellingProductListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.HomePageRepairCategory;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairCategoriesList;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class HomepageFragment extends Fragment implements BestSellingProductListener {

    private ArrayList<HomePageRepairCategory> homePageRepairCategories;
    private ArrayList<RepairCategoriesList> repairCategoriesLists;
    private GridView gvHomePageRepairCategories;
    private HomePageRepairCategoryAdapter adapterRepairCategories;

    private RecyclerView rvBestSellingProducts;
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private BestSellingProductAdapter adapter;
    private int page = 1;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_homepage, container, false);

        rvBestSellingProducts = view.findViewById(R.id.rvBestSellingProducts);

        ReparaTechSingleton.getInstance(getContext()).setBestSellingProductsListener(this);
        bestSellingProducts = ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsBD();
        ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsFromApi(page);
        bestSellingProducts = ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsBD();

        LinearLayoutManager layoutManager = new LinearLayoutManager(
                getActivity(), LinearLayoutManager.HORIZONTAL, false
        );
        rvBestSellingProducts.setLayoutManager(layoutManager);

        adapter = new BestSellingProductAdapter(getContext(), bestSellingProducts);
        rvBestSellingProducts.setAdapter(adapter);

        repairCategoriesLists = ReparaTechSingleton.getInstance(getContext()).getAllRepairCategoriesListDB();
        homePageRepairCategories = new ArrayList<>();

        for (RepairCategoriesList repairCategory : repairCategoriesLists) {
            homePageRepairCategories.add(new HomePageRepairCategory(
                    repairCategory.getId(),
                    repairCategory.getTitle(),
                    repairCategory.getImg()
            ));
        }

        gvHomePageRepairCategories = view.findViewById(R.id.gvReparacoes);
        adapterRepairCategories = new HomePageRepairCategoryAdapter(getActivity(), homePageRepairCategories);
        gvHomePageRepairCategories.setAdapter(adapterRepairCategories);

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

    @Override
    public void onProductsFetched(ArrayList<BestSellingProduct> products) {
        bestSellingProducts.clear();
        bestSellingProducts.addAll(products);
        adapter.notifyDataSetChanged();
    }
}