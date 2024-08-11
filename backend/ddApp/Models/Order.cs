namespace ddApp.Models
{
    public class Order
    {
        public int OrderID { get; set; }
        public int? CustomerID { get; set; } 
        public int? UserID { get; set; } 
        public DateTime OrderDate { get; set; }
        public string OrderStatus { get; set; }

        
        public User User { get; set; }
        public Customer Customer { get; set; }
        public ICollection<OrderItem> OrderItems { get; set; }
    }
}