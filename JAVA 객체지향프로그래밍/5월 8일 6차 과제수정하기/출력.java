public class 출력 {

    public void 메뉴() {
        System.out.println("주문하시려면 1을 아니면 다른 숫자를 눌러주세요.");
        System.out.println("짜장면은 5000원");
        System.out.println("짬뽕은 6000원");
        System.out.println("탕수육은 15000원");
        System.out.println("볶음밥은 7000원");
        System.out.println("짜장밥은 7000원");
        System.out.println(" ");
    }

    public void 음식(String 종류, int 그릇, int 금액) {
        System.out.println(종류 + " " + 그릇 + "그릇은" + 금액 + "원입니다.");
    }

    public void 주문여부() {
        System.out.println("주문하시겠습니까?");
        System.out.println("1. 예(숫자 1입력) 2. 아니오(1을 제외한 다른 숫자 입력)");
        System.out.print("선택 : ");
    }
}
