import java.util.Scanner;

public class FOOD {
    private static int 주문;
    private static int 그릇1;
    private static int 그릇2;
    private static int 그릇3;
    private static int 그릇4;
    private static int 그릇5;

    public static void main(String args[]) {
        Scanner sc=new Scanner(System.in);
        출력 output=new 출력();
        계산 음식값=new 계산();
        입력 INPUT=new 입력();

        주문 = 1;
        while (true){
            output.주문여부();
            주문=sc.nextInt();

            if (주문 != 1) break;
            output.메뉴();
            INPUT.input1();
            그릇1 = INPUT.get그릇1();
            음식값.짜장면(그릇1);
            output.음식("짜장면", 그릇1, 음식값.짜장면(그릇1));

            INPUT.input2();
            그릇2 = INPUT.get그릇2();
            음식값.짬뽕(그릇2);
            output.음식("짬뽕", 그릇1, 음식값.짬뽕(그릇2));

            INPUT.input3();
            그릇3 = INPUT.get그릇3();
            음식값.탕수육(그릇3);
            output.음식("탕수육", 그릇1, 음식값.탕수육(그릇3));

            INPUT.input4();
            그릇4 = INPUT.get그릇4();
            음식값.볶음밥(그릇4);
            output.음식("볶음밥", 그릇1, 음식값.볶음밥(그릇4));

            INPUT.input5();
            그릇5 = INPUT.get그릇5();
            음식값.짜장밥(그릇5);
            output.음식("짜장밥", 그릇1, 음식값.짜장밥(그릇5));
        }
        int 합계 = 음식값.짜장면(그릇1) + 음식값.짬뽕(그릇2) + 음식값.탕수육(그릇3) + 음식값.볶음밥(그릇4) + 음식값.짜장밥(그릇5);

        System.out.println(" ");
        System.out.print("주문하신 음식의 값은 " + 합계 + "원입니다.");
    }
}
