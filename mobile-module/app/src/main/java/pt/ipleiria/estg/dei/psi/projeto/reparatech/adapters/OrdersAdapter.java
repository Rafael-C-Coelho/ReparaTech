package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;

public class OrdersAdapter extends BaseAdapter {
    private final Context context;
    private final ArrayList<Order> orders;
    private final LayoutInflater inflater;

    public OrdersAdapter(Context context, ArrayList<Order> orders) {
        this.context = context;
        this.orders = orders;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public int getCount() {
        return orders.size();
    }

    @Override
    public Order getItem(int position) {
        return orders.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder holder;

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_order, null);
        }

        ViewHolder viewHolderList = (ViewHolder) convertView.getTag();
        if (viewHolderList == null) {
            viewHolderList = new ViewHolder(convertView);
            convertView.setTag(viewHolderList);
        }
        viewHolderList.update(orders.get(position));

        return convertView;
    }

    private static class ViewHolder {
        TextView orderIdText;
        TextView statusText;
        TextView createdAtText;
        TextView addressText;
        TextView zipCodeText;

        public ViewHolder(View view) {
            orderIdText = view.findViewById(R.id.orderIdText);
            statusText = view.findViewById(R.id.statusText);
            createdAtText = view.findViewById(R.id.createdAtText);
            addressText = view.findViewById(R.id.addressText);
            zipCodeText = view.findViewById(R.id.zipCodeText);
        }

        public void update(Order order) {
            orderIdText.setText(String.valueOf(order.getId()));
            statusText.setText(order.getStatus());
            createdAtText.setText(order.getCreatedAt());
            addressText.setText(order.getAddress());
            zipCodeText.setText(order.getZipCode());
        }
    }
}