

public class FOOD {

    public static void main(String args[]) {
        출력 output=new 출력();
        계산 음식값=new 계산();
        입력 INPUT=new 입력();

        output.메뉴();

        INPUT.input1();
        음식값.짜장면(그릇1);
        System.out.println("짜장면 " + 그릇1 + "그릇은" + 음식값.짜장면(그릇1) + "원입니다.");

        INPUT.input2();
        음식값.짬뽕(그릇2);
        System.out.println("짬뽕 " + 그릇2 + "그릇은" + 음식값.짬뽕(그릇2) + "원입니다.");

        INPUT.input3();
        음식값.탕수육(그릇3);
        System.out.println("탕수육 " + 그릇3 + "그릇은" + 음식값.탕수육(그릇3) + "원입니다.");

        INPUT.input4();
        음식값.볶음밥(그릇4);
        System.out.println("탕수육 " + 그릇4 + "그릇은" + 음식값.볶음밥(그릇4) + "원입니다.");

        INPUT.input5();
        음식값.짜장밥(그릇5);
        System.out.println("짜장밥 " + 그릇5 + "그릇은" + 음식값.짜장밥(그릇5) + "원입니다.");

        int 합계 = 음식값.짜장면(그릇1) + 음식값.짬뽕(그릇2) + 음식값.탕수육(그릇3) + 음식값.볶음밥(그릇4) + 음식값.짜장밥(그릇5);

        System.out.println(" ");
        System.out.print("주문하신 음식의 값은 " + 합계 + "입니다.");
    }
}
