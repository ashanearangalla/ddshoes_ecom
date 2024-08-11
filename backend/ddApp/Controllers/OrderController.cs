using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class OrderController : ControllerBase
    {
        private readonly IOrderRepository _orderRepository;
        private readonly IMapper _mapper;

        public OrderController(IOrderRepository orderRepository, IMapper mapper)
        {
            _orderRepository = orderRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<OrderDto>))]
        public IActionResult GetOrders()
        {
            var orders = _mapper.Map<List<OrderDto>>(_orderRepository.GetOrders());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(orders);
        }

        [HttpGet("{orderId}")]
        [ProducesResponseType(200, Type = typeof(OrderDto))]
        [ProducesResponseType(400)]
        public IActionResult GetOrder(int orderId)
        {
            if (!_orderRepository.OrderExists(orderId))
                return NotFound();

            var order = _mapper.Map<OrderDto>(_orderRepository.GetOrder(orderId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(order);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreateOrder([FromBody] OrderDto orderCreate)
        {
            if (orderCreate == null)
                return BadRequest(ModelState);

            var orderMap = _mapper.Map<Order>(orderCreate);

            if (!_orderRepository.CreateOrder(orderMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{orderId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdateOrder(int orderId, [FromBody] OrderDto updatedOrder)
        {
            if (updatedOrder == null || orderId != updatedOrder.OrderID)
                return BadRequest(ModelState);

            if (!_orderRepository.OrderExists(orderId))
                return NotFound();

            var orderMap = _mapper.Map<Order>(updatedOrder);

            if (!_orderRepository.UpdateOrder(orderMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{orderId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeleteOrder(int orderId)
        {
            if (!_orderRepository.OrderExists(orderId))
                return NotFound();

            var order = _orderRepository.GetOrder(orderId);

            if (!_orderRepository.DeleteOrder(order))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpGet("lastOrderId")]
        [ProducesResponseType(200)]
        [ProducesResponseType(400)]
        public IActionResult GetLastOrderId()
        {
            var lastOrderId = _orderRepository.GetOrders().OrderByDescending(o => o.OrderID).FirstOrDefault()?.OrderID;

            if (lastOrderId == null)
            {
                return NotFound();
            }

            return Ok(lastOrderId);
        }

        // New endpoint to get orders by user ID
        [HttpGet("user/{userId}")]
        [ProducesResponseType(200, Type = typeof(IEnumerable<OrderDto>))]
        [ProducesResponseType(400)]
        public IActionResult GetOrdersByUserId(int userId)
        {
            var orders = _mapper.Map<List<OrderDto>>(_orderRepository.GetOrdersByUserId(userId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(orders);
        }

        [HttpGet("user/order/{userId}")]
        [ProducesResponseType(200, Type = typeof(IEnumerable<OrderDetailDto>))]
        [ProducesResponseType(400)]
        public IActionResult GetUserOrdersByUserId(int userId)
        {
            var orders = _orderRepository.GetUserOrdersByUserId(userId);
            var orderDetails = orders.Select(o => new OrderDetailDto
            {
                OrderID = o.OrderID,
                OrderDate = o.OrderDate,
                OrderStatus = o.OrderStatus,
                OrderItems = o.OrderItems.Select(oi => new OrderItemUserDto
                {
                    ProductID = oi.ProductID,
                    Quantity = oi.Quantity,
                    ProductName = oi.Product.ProductName
                }).ToList()
            }).ToList();

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(orderDetails);
        }
    }
}
