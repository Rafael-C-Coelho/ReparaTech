package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.HorizontalScrollView;
import android.widget.LinearLayout;
import android.widget.ListView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.BestSellingProductAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.BestSellingProduct;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class HomepageFragment extends Fragment {

    private HorizontalScrollView hScrollBestSellingProducts;
    private LinearLayout llBestSellingProducts;
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private BestSellingProductAdapter adapter;
    private int page = 1;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_homepage, container, false);

        hScrollBestSellingProducts = view.findViewById(R.id.hScrollBestSellingProducts);
        llBestSellingProducts = view.findViewById(R.id.BestSellingProducts);


        bestSellingProducts = ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsBD();
        if (bestSellingProducts.isEmpty()) {
            ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsFromApi(page);
            bestSellingProducts = ReparaTechSingleton.getInstance(getContext()).getBestSellingProductsBD();
        }
        adapter = new BestSellingProductAdapter(getContext(), bestSellingProducts);

        return view;
    }

}