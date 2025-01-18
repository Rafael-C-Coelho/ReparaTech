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
import android.widget.ListView;
import android.widget.SearchView;

import java.util.ArrayList;
import java.util.List;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.OrdersAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.UpdateOrdersListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;


public class OrderListFragment extends Fragment implements UpdateOrdersListener {

    private ListView listView;
    private OrdersAdapter adapter;
    private ArrayList<Order> orders;
    private SwipeRefreshLayout swipeRefreshLayout;
    private boolean isLoading = false;
    private int page = 1;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_orders_list, container, false);

        ReparaTechSingleton.getInstance(getContext()).setUpdateOrdersListener(this);

        listView = view.findViewById(R.id.lvOrders);
        swipeRefreshLayout = view.findViewById(R.id.srOrders);
        orders = new ArrayList<>();
        adapter = new OrdersAdapter(getContext(), orders);
        listView.setAdapter(adapter);
        swipeRefreshLayout.setOnRefreshListener(this::onRefresh);

        listView.setOnScrollListener(new AbsListView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(AbsListView view, int scrollState) {
                if (scrollState == AbsListView.OnScrollListener.SCROLL_STATE_IDLE) {
                    if (listView.getLastVisiblePosition() >= listView.getCount() - 1 && !isLoading) {
                        isLoading = true;
                        page++;
                        ReparaTechSingleton.getInstance(getContext()).getOrders(page);
                    }
                }
            }

            @Override
            public void onScroll(AbsListView view, int firstVisibleItem, int visibleItemCount, int totalItemCount) {
            }
        });

        listView.setOnItemClickListener((parent, view1, position, id) -> {
            Order order = orders.get(position);
            Intent intent = new Intent(getContext(), OrderDetailsActivity.class);
            intent.putExtra("order_id", order.getId());
            startActivity(intent);
        });

        loadOrders();
        return view;
    }

    private void onRefresh() {
        isLoading = true;
        swipeRefreshLayout.setRefreshing(true);
        page = 1;

        ReparaTechSingleton.getInstance(getContext()).clearBookingsDB();
        ReparaTechSingleton.getInstance(getContext()).getOrders(page);
        swipeRefreshLayout.setRefreshing(false);
    }

    private void loadOrders() {
        orders.clear();
        orders.addAll(ReparaTechSingleton.getInstance(getContext()).getOrdersDB());
        adapter.notifyDataSetChanged();
    }

    @Override
    public void reloadListOrders(boolean success) {
        loadOrders();
    }
}