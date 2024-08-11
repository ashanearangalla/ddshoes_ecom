namespace ddApp.Models
{
    public class Customer
    {
        public int CustomerID { get; set; }
        public string CustomerName { get; set; }
        public string Email { get; set; }
        public string Phone { get; set; }

      
        public ICollection<Order> Orders { get; set; }
        public ICollection<PreOrder> PreOrders { get; set; }
    }
}