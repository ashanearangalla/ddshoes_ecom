namespace ddApp.Dto
{
    public class OrderDto
    {
        public int OrderID { get; set; }
        public int? CustomerID { get; set; } // Foreign key to Customer
        public int? UserID { get; set; } // Foreign key to User
        public DateTime OrderDate { get; set; }
        public string OrderStatus { get; set; }
    }
}
