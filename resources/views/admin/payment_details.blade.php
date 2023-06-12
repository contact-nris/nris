<div class="bg-white">
    <table class="table-detail table-bordered table-sm table">
        <thead>
            <tr>
                <th colspan="2" class="bg-gray-dark-lighter text-dark text-center" style="font-size: 22px;">Payment
                    Details</th>
            </tr>
            <tr>
                <th>User</th>
                <td><?php echo $pay_data['user']; ?> </td>
            </tr>
            <tr>
                <th>Payer Mail</th>
                <td><?php echo $pay_data['payer_email']; ?> </td>
            </tr>
            <tr>
                <th>Transaction ID</th>
                <td class="text-green"><?php echo $pay_data['txt_id']; ?></td>
            </tr>
            <tr>
                <th>Payable Amount</th>
                <td><?php echo $pay_data['amount']; ?> </td>
            </tr>
            <tr>
                <th>currency</th>
                <td><?php echo $pay_data['currency']; ?> </td>
            </tr>
            <tr>
                <th>payer_status</th>
                <td><?php echo $pay_data['payer_status']; ?> </td>
            </tr>
            <tr>
                <th>payment_status</th>
                <td><?php echo $pay_data['pay_status']; ?> </td>
            </tr>
            <tr>
                <th>created_at</th>
                <td><?php echo date('d M, Y', strtotime($pay_data['create_at'])); ?> </td>
            </tr>
        </thead>
    </table>
</div>
