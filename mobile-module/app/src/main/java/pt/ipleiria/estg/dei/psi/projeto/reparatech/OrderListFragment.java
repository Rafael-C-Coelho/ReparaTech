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
import java.util.List;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.OrderListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.MyBookingAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBooking;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.OrderDisplay;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechDBHelper;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.SalesHasProduct;


public class OrderListFragment extends Fragment {

    private ListView lvOrders;
    private ArrayList<Order> orders;
    private ArrayList<OrderDisplay> orderDisplays;

    private SearchView searchView;
    private OrderListAdapter adapter;
    private SwipeRefreshLayout swipeRefreshLayout;
    private boolean isLoading = false;

    public OrderListFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        View view = inflater.inflate(R.layout.fragment_order_list, container, false);

        setHasOptionsMenu(true);

        lvOrders = view.findViewById(R.id.LvOrders);

        swipeRefreshLayout = view.findViewById(R.id.swipe_refresh_layout);
        swipeRefreshLayout.setOnRefreshListener(this::onRefresh);

        ArrayList<Order> orders = new ReparaTechDBHelper(getContext()).getAllOrdersDB();
        ArrayList<OrderDisplay> orderDisplays = new ArrayList<>();

        for (Order order : orders) {
            ArrayList<SalesHasProduct> products = new ReparaTechDBHelper(getContext()).getProductsByOrderId(order.getId());
            StringBuilder productNames = new StringBuilder();
            int totalQuantity = 0;
            for (SalesHasProduct product : products) {
                productNames.append(product.getProductName()).append(", ");
                totalQuantity += product.getQuantity();
            }
            orderDisplays.add(new OrderDisplay(order.getId(), order.getStatus(), order.getTotalOrder(), productNames.toString(), totalQuantity));
        }

        OrderListAdapter adapter = new OrderListAdapter(getContext(), orderDisplays);
        lvOrders.setAdapter(adapter);

        lvOrders.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent intent = new Intent(getContext(), OrderDetailActivity.class);
                intent.putExtra(OrderDetailActivity.ID_ORDER, (int) id);
                startActivity(intent);
            }
        });

        return view;
    }

    public void onCreateOptionsMenu(@NonNull Menu menu, @NonNull MenuInflater inflater) {
        inflater.inflate(R.menu.search_menu, menu);
        MenuItem searchItem = menu.findItem(R.id.search_item);
        searchView = (SearchView) searchItem.getActionView();
        searchView.setQueryHint("Search Orders");
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                return false;
            }
            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<Order> orders = new ArrayList<>();
                for (Order order : orders) {
                    if (order.getStatus().toLowerCase().contains(newText.toLowerCase())) {
                        orders.add(order);
                    }
                }
                orderDisplays = new ArrayList<>();
                lvOrders.setAdapter(new OrderListAdapter(getContext(), orderDisplays));
                return true;
            }
        });
    }

    private void onRefresh() {
        isLoading = true;
        swipeRefreshLayout.setRefreshing(true);

        ReparaTechSingleton.getInstance(getContext()).clearOrdersDB();
        ReparaTechSingleton.getInstance(getContext()).getOrders();
        ReparaTechSingleton.getInstance(getContext()).setOrderListener(success -> {
            if (success) {
                orders.clear();
                orders.addAll(ReparaTechSingleton.getInstance(getContext()).getOrdersDB());
                adapter.notifyDataSetChanged();
            }
            swipeRefreshLayout.setRefreshing(false);
            isLoading = false;
        });
    }


    public void reloadListOrders(boolean success, int i) {
        if (success) {
            orders.clear();
            orders.addAll(ReparaTechSingleton.getInstance(getContext()).getOrdersDB());
            adapter.notifyDataSetChanged();
            isLoading = false;
        }
    }
}