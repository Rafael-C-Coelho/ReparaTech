package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class ProductsListFragment extends Fragment {


    private ListView lvProducts;
    private ArrayList<Product> products;

    private SearchView searchView;
    private SwipeRefreshLayout swipeRefreshLayout;

    public ProductsListFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        View view= inflater.inflate(R.layout.fragment_products_list, container, false);

        setHasOptionsMenu(true);

        lvProducts = view.findViewById(R.id.LvProducts);

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layout);
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                ProductsListFragment.this.onRefresh();
            }
        });

        products = ReparaTechSingleton.getInstance(getContext()).getProductsDB();
        lvProducts.setAdapter(new ProductsListAdapter(getContext(), products));
        lvProducts.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent intent = new Intent(getContext(), DetailsProductActivity.class);
                intent.putExtra(DetailsProductActivity.ID_PRODUCT, (int) id);
                startActivity(intent);
            }
        });

        return view;
    }

    @Override
    public void onCreateOptionsMenu(@NonNull Menu menu, @NonNull MenuInflater inflater) {
        inflater.inflate(R.menu.search_menu, menu);
        MenuItem searchItem = menu.findItem(R.id.search_item);
        searchView = (SearchView) searchItem.getActionView();
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<Product> tempProducts = new ArrayList<>();
                for (Product product : products) {
                    if (product.getName().toLowerCase().contains(newText.toLowerCase())) {
                        tempProducts.add(product);
                    }
                }
                lvProducts.setAdapter(new ProductsListAdapter(getContext(), tempProducts));
                return true;
            }
        });
    }

    public void onRefresh() {
        products = ReparaTechSingleton.getInstance(getContext()).getProductsDB();
        lvProducts.setAdapter(new ProductsListAdapter(getContext(), products));
        swipeRefreshLayout.setRefreshing(false);
    }
}