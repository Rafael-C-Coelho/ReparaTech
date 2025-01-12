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
import android.widget.AbsListView;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;

import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.DetailsProductActivity;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class ProductsListFragment extends Fragment {
    private ListView lvProducts;
    private ArrayList<Product> products;

    private SearchView searchView;
    private ProductsListAdapter adapter;
    private SwipeRefreshLayout swipeRefreshLayout;
    private int page = 1;
    private boolean isLoading = false; // To prevent multiple requests

    public ProductsListFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_products_list, container, false);

        setHasOptionsMenu(true);

        lvProducts = view.findViewById(R.id.LvProducts);

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layout);
        swipeRefreshLayout.setOnRefreshListener(this::onRefresh);

        products = ReparaTechSingleton.getInstance(getContext()).getProductsDB();
        if (products.isEmpty()) {
            ReparaTechSingleton.getInstance(getContext()).getProductsFromAPI(page);
            products = ReparaTechSingleton.getInstance(getContext()).getProductsDB();
        }
        adapter = new ProductsListAdapter(getContext(), products);
        lvProducts.setAdapter(adapter);

        // Set item click listener
        lvProducts.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent intent = new Intent(getContext(), DetailsProductActivity.class);
                intent.putExtra(DetailsProductActivity.ID_PRODUCT, (int) id);
                startActivity(intent);
            }
        });

        // Set scroll listener
        lvProducts.setOnScrollListener(new AbsListView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(AbsListView view, int scrollState) {
            }

            @Override
            public void onScroll(AbsListView view, int firstVisibleItem, int visibleItemCount, int totalItemCount) {
                if (!isLoading && (firstVisibleItem + visibleItemCount >= totalItemCount) && totalItemCount > 0) {
                    fetchMoreProducts();
                    lvProducts.refreshDrawableState();
                }
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
        // Refresh the list
        isLoading = true;
        swipeRefreshLayout.setRefreshing(true);
        page = 1;
        ReparaTechSingleton.getInstance(getContext()).clearProductsDB();
        ReparaTechSingleton.getInstance(getContext()).getProductsFromAPI(page);
        products.clear();
        swipeRefreshLayout.setRefreshing(false);
        products.addAll(ReparaTechSingleton.getInstance(getContext()).getProductsDB());
        adapter.notifyDataSetChanged();
        isLoading = false;
    }

    private void fetchMoreProducts() {
        // Simulate a Volley request here
        // Example:
        isLoading = true;
        int prevProductsSize = products.size();
        ReparaTechSingleton.getInstance(getContext()).getProductsFromAPI(page + 1);
        int currentProductsSize = ReparaTechSingleton.getInstance(getContext()).getProductsDB().size();
        if (currentProductsSize == prevProductsSize) {
            isLoading = false;
            return;
        }
        page++;
        products.clear();
        products.addAll(ReparaTechSingleton.getInstance(getContext()).getProductsDB());
        adapter.notifyDataSetChanged();
        lvProducts.refreshDrawableState();
        isLoading = false;
    }
}
