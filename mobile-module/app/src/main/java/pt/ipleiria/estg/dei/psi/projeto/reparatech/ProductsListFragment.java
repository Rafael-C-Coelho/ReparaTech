package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListAdapter;
import android.widget.ListView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class ProductsListFragment extends Fragment {


    private ListView lvProducts;
    private ArrayList<Product> products;

    public ProductsListFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        View view= inflater.inflate(R.layout.fragment_products_list, container, false);

        setHasOptionsMenu(true);

        lvProducts = view.findViewById(R.id.LvProducts);
        products = ReparaTechSingleton.getInstance(getContext()).getProducts();
        lvProducts.setAdapter((ListAdapter) new ProductsListAdapter(getContext(), products));
        lvProducts.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent intent = new Intent(getContext(), MenuMainActivity.class);
                startActivity(intent);
            }
        });

        return view;
    }
}